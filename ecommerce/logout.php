<?php
session_start();
session_destroy();

// Redirect to login page 
header("Location: K00319172login.php?logout=success");
exit();