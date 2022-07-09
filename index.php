<?php
$ip = $_SERVER['REMOTE_ADDR'];
file_put_contents('logs.txt', $ip, FILE_APPEND);
$messages_buffer_file = 'messages.json';
$messages_buffer_size = 10;

if ( isset($_POST['content']) and isset($_POST['name']) )
{
  $buffer = fopen($messages_buffer_file, 'r+b');
  flock($buffer, LOCK_EX);
  $buffer_data = stream_get_contents($buffer);
  
  $messages = $buffer_data ? json_decode($buffer_data, true) : array();
  $next_id = (count($messages) > 0) ? $messages[count($messages) - 1]['id'] + 1 : 0;
  $messages[] = array('id' => $next_id, 'time' => time(), 'name' => $_POST['name'], 'content' => $_POST['content']);
  
  if (count($messages) > $messages_buffer_size)
    $messages = array_slice($messages, count($messages) - $messages_buffer_size);

  ftruncate($buffer, 0);
  rewind($buffer);
  fwrite($buffer, json_encode($messages));
  flock($buffer, LOCK_UN);
  fclose($buffer);
  
 
  
  exit();
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<!DOCTYPE html>
<html>
<head>
 <meta name="viewport" content="width=device-width, initial-scale=1.0">

</body>
<style type="text/css">
.subtitle {
    font-family: Segoe UI Light;
}
body,td,th {
    color: #FFFFFF;
}
.b {
    font-family: Segoe UI Light;
}
.container .chatapp #messages li {
    font-family: Segoe UI Light;
}
.container .chatapp form p {
    font-family: Segoe UI Light;
}
body {
    background-color: #312F2F;
}
.gbngngn {
    font-family: Segoe UI Light;
}
.button.large.hpbottom {
    font-family: Segoe UI Light;
}
.button .button.large.hpbottom strong {
    font-family: Segoe UI Light;
}
.button {
    font-family: Segoe UI Light;
}
.button a {
    font-family: Segoe UI Light;
}
.button1 {    font-family: Segoe UI Light;
}
.button1 {    font-family: Segoe UI Light;
}
.h strong {
    font-family: Segoe UI Light;
}
</style>
</html>
<head>
  
 
  <body oncontextmenu="return false;">
  <head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="https://cdn.discordapp.com/attachments/933052459339878450/977325208983719966/Bez_tytuu.png">
</head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <header>
  <a href="https://stronachleba.github.io/Chleb/">Strona Główna</a>
  <a href="Co nowego.html">Co nowego?</a>
  <a href="https://discord.gg/Jgk8QVTPQq">Internetowe Kamienie</a>
   </header>
  <title>BreadChat 0.1 RTM</title>
  <script type="text/javascript" src="jquery-1.4.2.min.js"></script>
<script type="text/javascript">
  
    $(document).ready(function(){
     
      $('ul#messages > li').remove();
      
      $('form').submit(function(){
        var form = $(this);
        var name =  form.find("input[name='name']").val();
        var content =  form.find("input[name='content']").val();
        
        
        
        if (name == '' || content == '')
          return false;
        
       
        $.post(form.attr('action'), {'name': name, 'content': content}, function(data, status){
          $('<li class="pending" />').text(content).prepend($('<small />').text(name)).appendTo('ul#messages');
          $('ul#messages').scrollTop( $('ul#messages').get(0).scrollHeight );
          form.find("input[name='content']").val('').focus();
        });
        return false;
      });
      
 
      var poll_for_new_messages = function(){
        $.ajax({url: 'messages.json', dataType: 'json', ifModified: true, timeout: 2000, success: function(messages, status){
        
          if (!messages)
            return;
          
          
          $('ul#messages > li.pending').remove();
          
        
          var last_message_id = $('ul#messages').data('last_message_id');
          
          if (last_message_id == null)
            last_message_id = -1;
          
         
          for(var i = 0; i < messages.length; i++)
          {
            var msg = messages[i];
            if (msg.id > last_message_id)
            {
              var date = new Date(msg.time * 1000);
              $('<li/>').text(msg.content).
                prepend( $('<small />').text(date.getHours() + ':' + date.getMinutes() + ':' + date.getSeconds() + ' ' + msg.name) ).
                appendTo('ul#messages');
              $('ul#messages').data('last_message_id', msg.id);
            }
          }
          
          
          $('ul#messages > li').slice(0, -50).remove();
          $('ul#messages').scrollTop( $('ul#messages').get(0).scrollHeight );
        }});
      };
      
     
      poll_for_new_messages();
      setInterval(poll_for_new_messages, 500);
    });
    // ]]>
  </script>
  <style type="text/css">
    
    
    html { margin: 0em; padding: 0; }
    body {
      <body oncontextmenu="return false;">
    margin: 2em;
    padding: 0;
    font-family: sans-serif;
    font-size: medium;
    color: #fff;
	background-color: #1d180c;
  
    background-image:url('http://www.example.com/yourfile.gif');
background-position: center;
background-size: cover;
}
    h1 { margin: 0; padding: 0; font-size: 3em; text-align: center;}
    h2 { text-align: center;}
    h3 {text-align: center;}
    p { text-align: center;}
    p.subtitle { margin: 0; padding: 0 0 0 0.125em; font-size: 1.00em; color: gray; }
    
    ul#messages { overflow: auto; height: 15em; margin: 1em 0; padding: 8px; list-style: none; background-color: #1d180c;
        border: 1px solid #2B2B2B; border-radius: 12px; color: #fff; display: block;}
    ul#messages li { margin: 0.35em 0; padding: 0; color: #fff;}
    ul#messages li small { display: block; font-size: 0.59em; color: #fff; }
    ul#messages li.pending { color: #fff; }
    
    form { font-size: 1em; margin: 1em 0;}
    form p { position: relative; margin: 0.5em 0; padding: 0; }
    form p input { font-size: 1em; width: 40%; height: 30px; border: 2px solid #9c9c9c; }
    form p input#name { width: 10em; }
    form p button {
    position: absolute;
    top: 1px;
    right: 1033px;
    height: 30px;
    border: 2px solid #2E2E2E;
    background: #1d180c;
    color: #fff;
    width: 77px;
	border-radius: 12px;
}
    
    ul#messages, form p, input#content { width: 70em; }
    
    pre { font-size: .77em; }

    .container {
        display: flex;
        justify-content: center;
        width: 100%;
    }
  .subtitle {
  font-family: Comic Sans MS;
}
  .subtitle {
  font-family: Segoe, Segoe UI, DejaVu Sans, Trebuchet MS, Verdana, sans-serif;
}
  .subtitle {
  font-family: Comic Sans MS;
}
  .h {
    font-family: Comic Sans MS;
}
  body,td,th {
    color: #FFFFFF;
}
  .poopy {
    font-family: Comic Sans MS;
}
  </style>
    
  
<meta name= />
    

<body>

  
<h1 class="gbngngn">
<h1 class="gbngngn">BreadChat 0.1 RTM </h1>
  
     <link rel="stylesheet" href="style.css">  
  <br>
<p class="subtitle">najlepsza alternatywa LyanoChatu <span style="color:red"> <3</span>&nbsp; </p>
	<br>
  
 
<div class="container">
  
  <header>
    <div class="chatapp">
      <ul id="messages">
        <li>Ładowanie, proszę zaczekać...</li>
        <li><strong><em>Jeśli widzisz ten ekran zbyt długo, to oznacza ze mamy czasowy problem z serwerem. Przepraszamy</em></strong></li>
       
      </ul>
      
      <table data-sortable="" data-sortable-initialized="true">
      <tbody>
      
      </tbody>
      </table>
      <form action="<?= htmlentities($_SERVER['PHP_SELF'], ENT_COMPAT, 'UTF-8'); ?>" method="post">
            <p>
              <input type="text" name="content" id="content" />
        </p>
      <p style="text-align: center; color: #1d180c;"><b>Pamiętaj! Wpisz Swój nick niżej!</b></p>
            <p style="text-align: right;">
              <label style="color: #1d180c;">
                <b>Nick:</b>
                <input type="text" name="name" id="name" value="Anonim" />
              </label>
              <button type="submit">Wyślij</button>
            </p>
      </form>
  </div>
</div>

<center><h3 class="gbngngn">━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━</h3></center>
<strong><h3 class="gbngngn" id="source">Twórca: Chleb <3&nbsp;</h3></center>
  <strong><h3 class="gbngngn" id="source">2017 - 2022&nbsp;</h3></center>

<strong><h3 class="gbngngn"> Pozdrowienia Dla: Athical (jak chcesz się tu znaleść to napisz do właściciela na discordzie Chleb#1037) </h3></center>
<center><h3 class="gbngngn">━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━</h3>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>

</body>
</html>