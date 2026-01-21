# Buto-Plugin-SmsPixie_v2

<p>SMS using <a href="http://www.pixie.se" target="_blank">Pixie</a> service.</p>
<ul>
<li><a href="https://pixie.se/support#api">https://pixie.se/support#api</a></li>
<li><a href="https://app.pixie.se/#settings/user">https://app.pixie.se/#settings/user</a> (token)</li>
<li>This is for the new service of Pixie after 2022.</li>
<li>If you are using the old service before 2022 one must migrate to new service.</li>
</ul>

<a name="key_0"></a>

## Settings

<pre><code>plugin:
  sms:
    pixie_v2:
      data:
        log: '/../buto_data/theme/[theme]/pixie_v2_log.yml'</code></pre>

<a name="key_1"></a>

## Usage

<pre><code>$data = new PluginWfArray();</code></pre>
<p>Identifying sender.
Alphanumeric, can have max 11 characters, number max 15 characters.</p>
<pre><code>$data-&gt;set('sender', 'Sender phone number');</code></pre>
<pre><code>$data-&gt;set('token', ' Token generated in pixie.se panel. ');</code></pre>
<pre><code>$data-&gt;set('to', ' Mobile number. ');</code></pre>
<p>cc param to send copies.</p>
<pre><code>$data-&gt;set('cc', array(' cc Mobile numbers (Optional). '));</code></pre>
<pre><code>$data-&gt;set('message', 'Message from my web site.');</code></pre>
<pre><code>$data-&gt;set('country', ' Optional default 46. ');</code></pre>
<pre><code>wfPlugin::includeonce('sms/pixie_v2');
PluginSmsPixie_v2::send($data);</code></pre>

<a name="key_2"></a>

## Widgets



<a name="key_2_0"></a>

### test

<p>Widget for testing purpose.</p>
<pre><code>type: widget
settings:
  role:
    item:
      - webmaster
data:
  plugin: sms/pixie_v2
  method: test
  data:
    sender: SMS-TEST
    token: ' my token '
    to: ' mobile number '
    country: '46'
    message: 'Testing SMS.'</code></pre>

<a name="key_3"></a>

## Methods



<a name="key_3_0"></a>

### send



<a name="key_3_1"></a>

### remove_first_zero



