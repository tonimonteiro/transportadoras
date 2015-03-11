<?php

namespace SimCms\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class UrlCustom extends AbstractPlugin
{

    /**
     *
     * @param string $url
     * @param string $replace
     * @param string $cleanWords
     * @param array $removeWords
     * @return mixed
     */
    public function friendly($url, $search=' ', $replace = '-', $cleanWords = true, $removeWords = array())
    {
        $newUrl = strtolower($url); //iconv("UTF-8", "ISO-8859-1//IGNORE", $url);
        $newUrl = htmlentities(strtolower($newUrl));
        $newUrl = preg_replace("/&(.)(acute|cedil|circ|ring|tilde|uml);/", "$1", $newUrl);
        $newUrl = preg_replace("/[^a-zA-Z0-9\s]/", "", $newUrl);
        $newUrl = preg_replace('/\s\s+/', ' ', $newUrl);

        // Remover as palavras que não ajudam no SEO
        // Coloco as palavras por defeito no $removeWords(), assim eu não esse array
        if($cleanWords) {
            $newUrl = $this->clean($newUrl, $search, $replace, $removeWords);
        }

        // Converte os espaços para o que o utilizador quiser
        // Normalmente um hífen ou um underscore
        return str_replace($search , $replace, $newUrl);
    }

    /**
     *
     * @param string $url
     * @param string $replace
     * @param array $removeWords
     * @param boolean $uniqueWords
     * @return string
     */
    protected function clean($url, $search, $replace, $removeWords = array(), $uniqueWords = true)
    {
        //Separar todas as palavras baseadas em espaços
        $urlSplit = explode($search, $url);

        //Criar o array de saída
        $result = array();

        //Faz-se um loop às palavras, remove-se as palavras indesejadas e mantém-se as que interessam
        foreach($urlSplit as $word)
        {
            if(! in_array($word, $removeWords) && ($uniqueWords ? ! in_array($word, $result) : true))
            {
                $result[] = $word;
            }
        }

        return implode($replace,$result);
    }
}