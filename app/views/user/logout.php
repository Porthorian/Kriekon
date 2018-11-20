<?php
if(isset($_SESSION[Config::get('session/user_session')])) {
  echo 'Session User Active';
} else
{
  header("Location: /");
}
