<?php

class AcfRenderTemplateDetect {

  public function __construct() {
    add_filter('acf-render-template-register', array( $this, 'registerDetectedTemplates' ));
  }

  public function registerDetectedTemplates( $templates ) {
    $td = get_template_directory();
    $tdc = get_stylesheet_directory();
    
    $newTemplates = $this->getTemplates( $td );
    foreach( $newTemplates as $nt ) {
      $templateName = str_replace('.php', '', $nt['filename']);
      $templates[ $templateName ] = array(
        'location' => $this->relativeLocation( $tdc ),
      );
    }

    if( $this->hasMultipleLocations( $td, $tdc )) {
      $newTemplates = $this->registerTemplates( $tdc );
      foreach( $newTemplates as $nt ) {
        $templateName = str_replace('.php', '', $nt['filename']);
        $templates[ $templateName ] = array(
          'location' => $this->relativeLocation( $tdc ),
        );
      }
    }

    return $templates;
  }

  // make location relative to wp-content dir
  public function relativeLocation( $themePath ) {
    $strip = strstr( $themePath, 'wp-content', true);
    $themePath = str_replace( $strip, '', $themePath);
    $themePath = str_replace( 'wp-content/', '', $themePath);
    return $themePath . '/acf-render/';
  }

  public function hasMultipleLocations( $themePath1, $themePath2 ) {
    if( $themePath1 != $themePath2 ) {
      return true;
    }
    return false;
  }

  public function getTemplates( $themePath ) {
    if( !$this->themeHasTemplates( $themePath )) {
      return false;
    }
    return $this->getNewTemplates( $themePath );
  }

  public function themeHasTemplates( $themePath ) {
    return is_dir( $themePath . '/acf-render' );
  }

  public function getNewTemplates( $themePath ) {
    $templates = array();
    $dir = new DirectoryIterator( $themePath . '/acf-render' );
    foreach( $dir as $fileinfo ) {
      if( !$fileinfo->isDot() ) {
        $templates[] = array(
          'pathname' => $fileinfo->getPathName(),
          'filename' => $fileinfo->getFileName(),
        );
      }
    }
    return $templates;
  }

}
