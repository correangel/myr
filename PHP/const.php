<?php
// Proyecto

define('PROY_URL_NOPROTOCOL', 'localhost/myr/');
define('PROY_URL_ESTATICA','http://'.PROY_URL_NOPROTOCOL);
define('PROY_URL','http://'.PROY_URL_NOPROTOCOL);    

define('PROY_URL_SSL','https://'.PROY_URL_NOPROTOCOL);
define('PROY_URL_NOSSL','http://'.PROY_URL_NOPROTOCOL);

define('PROY_URL_AMIGABLE','localhost/myr/');
define('PROY_URL_ACTUAL_DINAMICA',curPageURL());
define('PROY_URL_ACTUAL',curPageURL(true));
define('PROY_URL_ACTUAL_NOSSL',curPageURL(true,false,'nunca'));
define('PROY_URL_ACTUAL_AMIGABLE',curPageURL(true,true));
define('PLATAFORMA_MOBIL',false);

define('__IVA__', 13); // Porcentaje de iva

// Niveles
define('_N_administrador',      'jefatura');
define('_N_tecnico',           'tecnico');
define('_N_agencia',            'agencia');

// Estados para articulos
define('_art_activo',           0);
define('_art_sin_stock_temp',   1);
define('_art_sin_stock_perm',   2);

/*
Constantes para mensajes
*/
define("_M_INFO",   0);
define("_M_ERROR",  1);
define("_M_NOTA",   2);

// CONSTANTES HTML
define('BR','<br />');

// Otros
define('COLORES', serialize(array('Multicolor','Amarillo','Naranja','Azul','Blanco','Gris','Negro','Rojo','Rosa','Verde','Violeta','Púrpura','Fucsia','Lavanda','Lila','Turquesa','Oro','Ladrillo','Plateado','Primaveral')));
define('STOPWORDS',serialize(array('para','de','la','que','el','en','y','a','los','del','se','las','por','un','con','no','una','su','al','es','lo','como','más','pero','sus','le','ya','o','fue','este','ha','sí','porque','esta','son','entre','está','cuando','muy','sin','sobre','ser','tiene','también','me','hasta','hay','donde','han','quien','están','estado','desde','todo','nos','durante','estados','todos','uno','les','ni','contra','otros','fueron','ese','eso','había','ante','ellos','e','esto','mí','antes','algunos','qué','unos','yo','otro','otras','otra','él','tanto','esa','estos','mucho','quienes','nada','muchos','cual','sea','poco','ella','estar','haber','estas','estaba','estamos','algunas','algo','nosotros','mi','mis','tú','te','ti','tu','tus','ellas','nosotras','vosotros','vosotras','os','mío','mía','míos','mías','tuyo','tuya','tuyos','tuyas','suyo','suya','suyos','suyas','nuestro','nuestra','nuestros','nuestras','vuestro','vuestra','vuestros','vuestras','esos','esas','','','estoy','estás','está','estamos','estáis','están','esté','estés','estemos','estéis','estén','estaré','estarás','estará','estaremos','estaréis','estarán','estaría','estarías','estaríamos','estaríais','estarían','estaba','estabas','estábamos','estabais','estaban','estuve','estuviste','estuvo','estuvimos','estuvisteis','estuvieron','estuviera','estuvieras','estuviéramos','estuvierais','estuvieran','estuviese','estuvieses','estuviésemos','estuvieseis','estuviesen','estando','estado','estada','estados','estadas','estad','he','has','ha','hemos','habéis','han','haya','hayas','hayamos','hayáis','hayan','habré','habrás','habrá','habremos','habréis','habrán','habría','habrías','habríamos','habríais','habrían','había','habías','habíamos','habíais','habían','hube','hubiste','hubo','hubimos','hubisteis','hubieron','hubiera','hubieras','hubiéramos','hubierais','hubieran','hubiese','hubieses','hubiésemos','hubieseis','hubiesen','habiendo','habido','habida','habidos','habidas','soy','eres','es','somos','sois','son','sea','seas','seamos','seáis','sean','seré','serás','será','seremos','seréis','serán','sería','serías','seríamos','seríais','serían','era','eras','éramos','erais','eran','fui','fuiste','fue','fuimos','fuisteis','fueron','fuera','fueras','fuéramos','fuerais','fueran','fuese','fueses','fuésemos','fueseis','fuesen','siendo','sido','tengo','tienes','tiene','tenemos','tenéis','tienen','tenga','tengas','tengamos','tengáis','tengan','tendré','tendrás','tendrá','tendremos','tendréis','tendrán','tendría','tendrías','tendríamos','tendríais','tendrían','tenía','tenías','teníamos','teníais','tenían','tuve','tuviste','tuvo','tuvimos','tuvisteis','tuvieron','tuviera','tuvieras','tuviéramos','tuvierais','tuvieran','tuviese','tuvieses','tuviésemos','tuvieseis','tuviesen','teniendo','tenido','tenida','tenidos','tenidas','tened')));
?>
