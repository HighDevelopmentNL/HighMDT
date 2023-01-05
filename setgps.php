<?php
$file = file_get_contents("Meldingen.json");
$data = json_decode($file, true);

$last_item    = end($data);
$last_item_id = $last_item['id'];

foreach ($data as $key => $value)
{
    if ($value['gmsrequest'] == "true")
    {
        $arr_index[] = $key;
    }
}

foreach ($arr_index as $i)
{
    unset($data[$i]);
}

$data[] = array(
    'id'             => json_encode(++$last_item_id),
    'gmsrequest'             => "true",
    'locx'          => $_GET['locx'],
    'locy'         => $_GET['locy'],
    'locz'          => $_GET['locz'],
    'steamnaam'           => $_POST['steamname'],
    'melding' => 'Locatie vanuit de Databank'
);
$output = array_values($data);
file_put_contents('Meldingen.json',json_encode($output), LOCK_EX);
header("location: houses");
