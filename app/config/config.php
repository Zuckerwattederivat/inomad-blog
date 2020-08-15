<?php
  // DB Parameters
  define('DB_HOST', 'localhost');
  define('DB_USER', 'root');
  define('DB_PASS', 'root');
  define('DB_NAME', 'iNomad');

  // App Root
  define('APPROOT', dirname(dirname(__FILE__)));
  // URL Root
  define('URLROOT', 'http://localhost:8888/inomad-blog');

  // Site Name
  define('SITENAME', 'iNomad');
  // Site Title Front
  define('SITETITLE', 'Blog');
  // Site Title Back
  define('TITLEBACK', 'Admin');

  // App Version
  define('APPVERSION', '1.0.0');
  // Your Mail
  define('YOURMAIL', 'iNomad@byom.de');
  // Adress
  define('ADRESS', [
    'street' => 'Heiligengeistfeld 69',
    'zip_and_city' => '20359 Hamburg',
    'country' => 'Germany'
  ]);
  // Site Description
  define(
    'SITEDESCRIPTION', 
    'We are an award winning blog community for digital nomads or travel loving people all around the world.'
  );
  
?>