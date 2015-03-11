<?php
namespace SimAds\Form;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\FileInput;

class MediaFilter extends InputFilter
{

    public function __construct()
    {
        $mediaFile = new FileInput('file');

        $mediaFile->setRequired(false);
        $mediaFile->getValidatorChain()
                //->attachByName('filesize',      array('max' => 409600))
                ->attachByName('filemimetype',  array('mimeType' => 'image/png,image/x-png,image/jpeg,image/jpg'))
                //->attachByName('fileimagesize', array('maxWidth' => 800, 'maxHeight' => 600))
                ;

        $mediaFile->getFilterChain()->attachByName('fileRenameUpload',
                                                    array(
                                                        'target'    => './public/files/ads/ads.png',
                                                        'randomize' => true,
                                                    ));
        $this->add($mediaFile);
    }
}
