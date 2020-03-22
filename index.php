<?php
/* HTML DOM PARSER */
include './core/simple_html_dom.php';


function GetData($base){
	$data = array(); $i = 0;
	include './core/curl_settings.php';

	$html = new simple_html_dom();
	$html->load($str);

	foreach($html->find('.offer-titlebox h1') as $element){
	       $data['header'] = trim($element->plaintext);}
	foreach($html->find('.price-label strong') as $element){
	       $data['price'] = trim($element->plaintext);}
	foreach($html->find('.offer-user__details h4 a') as $element){
	       $data['author'] = trim($element->plaintext);}
	foreach($html->find('.offer-titlebox__details em') as $element){
	       $data['date'] = preg_replace('/ {2,}/',' ',$element->plaintext);}
	foreach($html->find('.user-since') as $element){
	       $data['reg-user'] = trim($element->plaintext);}
	foreach($html->find('.offer-user__address p') as $element){
	       $data['location'] = trim($element->plaintext);}
	foreach($html->find('#textContent') as $element){
	       $data['description'] = preg_replace('/ {2,}/',' ',$element->plaintext);}
	foreach ($html->find('img') as  $element) {
			if ($element->src != null) {
				$data['images'][$i] = $element->src;
			}
			$i++;
	}
	$html->clear(); 
	unset($html);
	return($data);

}



$handle = fopen("links.txt", "r");
while (!feof($handle)) {
    $base = trim(str_replace(' ', '',(fgets($handle, 4096))));
    ?><pre><?php
	print_r (GetData($base));
	?></pre><?php
}
fclose($handle);

?>