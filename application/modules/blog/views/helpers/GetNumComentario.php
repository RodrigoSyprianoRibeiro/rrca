<?php

class Zend_View_Helper_GetNumComentario {

    function getNumComentario($url) {
        $urlCompleta = 'http://graph.facebook.com/?ids='.$url;
	$ch = curl_init();
	$timeout = 10;
	curl_setopt ($ch, CURLOPT_URL, $urlCompleta);
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	$retorno = curl_exec($ch);
	curl_close($ch);
        $json = json_decode($retorno, false);

        $numeroConmentarios = isset($json->$url->comments) ? $json->$url->comments : 0;
        
        if ($numeroConmentarios == 0) {
            return "Nenhum Comentário";
        } if ($numeroConmentarios == 1) {
            return "1 Comentário";
        } else {
            return $numeroConmentarios." Comentários";
        }
    }
}