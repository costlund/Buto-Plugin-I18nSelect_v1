<?php
/**
 * <p>User can change language in session.
 */
class PluginI18nSelect_v1{
  public static $param_name = 'i18n_select_language';
  function __construct($buto) {
    if($buto){
      wfPlugin::includeonce('wf/array');
    }
  }
  /**
   * Widget to let user select language.
   */
  public function widget_select($data){
    $settings = new PluginWfArray($GLOBALS['sys']['settings']);
    
    $flags = new PluginWfArray($settings->get('plugin/i18n/select_v1/data/flags'));
    
    $languages = wfI18n::getLanguages();
    $language = wfI18n::getLanguage();
    $item = array();
    foreach ($languages as $key => $value) {
      $active = '';
      if($value == $language){
        $active = ' active';
      }
      $item[] = wfDocument::createHtmlElement('a', array(
        wfDocument::createHtmlElement('img', null, array('src' => $flags->get($value), 'style' => 'width:30px')),
        wfDocument::createHtmlElement('span', 'language_'.$value),
      ), array('class' => 'list-group-item'.$active, 'href' =>  '/'.$settings->get('default_class').'/'.$settings->get('default_method').'/'.PluginI18nSelect_v1::$param_name .'/'.$value));
    }
    $list_group = wfDocument::createHtmlElement('div', $item, array('class' => 'list-group'));
    wfDocument::renderElement(array($list_group));
  }
  /**
   * Event to set langage in session.
   * Run on event document_render_before.
   */
  public function event_set_language(){
    if(wfRequest::get(PluginI18nSelect_v1::$param_name)){
      $languages = wfI18n::getLanguages();
      if(array_search(wfRequest::get(PluginI18nSelect_v1::$param_name), $languages)!==false){
        wfI18n::setLanguage(wfRequest::get(PluginI18nSelect_v1::$param_name));
      }
    }
  }
}