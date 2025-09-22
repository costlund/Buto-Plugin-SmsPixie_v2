<?php
class PluginSmsPixie_v2{
  public static function send($data){
    wfPlugin::includeonce('wf/array');
    /**
     * If param country is set but empty we have to set it to a valid one.
     */
    if(!$data->get('country')){
      $data->set('country', '46');
    }
    /**
     * Defaults
     */
    $default = new PluginWfArray();
    $default->set('country', '46');
    $default->set('sender', '_sender');
    $default->set('token', '_token');
    $default->set('to', '_to');
    $default->set('message', '_message');
    $default->set('cc', array());
    /**
     * Merge defaults.
     */
    $default = new PluginWfArray(array_merge($default->get(), $data->get()));
    /**
     * phone clean
     */
    $default->set('to', PluginSmsPixie_v2::remove_first_zero($default->get('to')));
    /**
     * recipients
     */
    $recipients = new PluginWfArray();
    $recipients->set(true, PluginSmsPixie_v2::merge_country_and_number($default->get('to'), $default->get('country')));
    /**
     * recipients, cc
     */
    foreach ($default->get('cc') as $key => $value) {
      $value = PluginSmsPixie_v2::remove_first_zero($value);
      $recipients->set(true, PluginSmsPixie_v2::merge_country_and_number($value, $default->get('country')));
    }
    /**
     * send
     */
    wfPlugin::includeonce('server/json');
    $server = new PluginServerJson();
    $server->token = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiJwZXRyaUBtYWMuY29tIiwianRpIjoiODNhN2I4ZjktMDU1ZC00M2IyLTgwNWYtNTdlOTg5NDY0ZTQ2IiwiaWF0IjoxNzU4MTEwOTM4LCJpZCI6IjExNjEwMjU0IiwiQ29tcGFueUlkIjoiMTE2MTAyNTQiLCJJc1N1YmFjY291bnQiOiJGYWxzZSIsIklzQXBpIjoiVHJ1ZSIsIklzQWRtaW4iOiJGYWxzZSIsIm5iZiI6MTc1ODExMDkzOCwiZXhwIjoyNTM0MDIzMDA4MDAsImlzcyI6InNtc0FwaSIsImF1ZCI6Imh0dHA6Ly9sb2NhbGhvc3Q6ODA4NS8ifQ.8hw1FA3UBr9DS-QTy41iqogkTAdcOWlvkUQ8uGYhFA8';
    $default->set('recipients', $recipients->get());
    $response = $server->send('https://app.pixie.se/api/v2/sms', $default->get());
    $default->set('response', $response);
    /**
     * Log
     */
    $settings = wfPlugin::getPluginSettings('sms/pixie_v2', true);
    if($settings->get('data/log')){
      $log = new PluginWfYml(wfGlobals::getAppDir().$settings->get('data/log'));
      $default->set('date', date('Y-m-d H:i:s'));
      $log->set('log/', $default->get());
      $log->save();
    }
    /**
     * 
     */
    return $default;
  }
  public static function merge_country_and_number($to, $country){
    if(substr($to, 0, 1)!='+'){
      return $country.$to;
    }else{
      return $to;
    }
  }
  public static function remove_first_zero($phone){
    if(wfPhpfunc::substr($phone, 0, 1) == '0'){
      $phone = wfPhpfunc::substr($phone, 1);
    }
    return $phone;
  }
  public function widget_test($data){
    $data = new PluginWfArray($data);
    $data = new PluginWfArray($data->get('data'));
    wfPlugin::includeonce('sms/pixie_v2');
    $result = $this->send($data);
    echo '<h1>Test widget</h1>';
    echo '<h2>Widget data</h2>';
    wfHelp::print($data);
    echo '<h2>Result</h2>';
    wfHelp::print($result);
  }
}