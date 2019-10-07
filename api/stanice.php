<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// database connection will be here
require_once "../server/baza.php";

$upit = "SELECT * FROM stanice INNER JOIN zupanije ON stanice.sta_zupanija_id = zupanije.zup_id ORDER BY stanice.sta_zupanija_id DESC";
$rezultat = $baza->query($upit);

if ($rezultat->num_rows > 0) {
  $stanice_arr = array();
  $stanice_arr['stanice'] = array();
  while ($redak = $rezultat->fetch_assoc()) {
    extract($redak);
    $stanica = array(
      'id' => $sta_id,
      'naziv' => $sta_naziv,
      'url' => $sta_url,
      'stream' => $sta_stream,
      'frekvencija' => $sta_frekvencija,
      'slika' => $sta_slika,
      'zupanija' => html_entity_decode($zup_naziv)
    );
    // var_dump($stanica);
    array_push($stanice_arr['stanice'], $stanica);
  }

  // set response code - 200 OK
  http_response_code(200);

  // show products data in json format
  // echo json_encode($stanice_arr, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
  echo json_encode($stanice_arr);
} else {
  // set response code - 404 Not found
  http_response_code(404);

  // tell the user no products found
  echo json_encode(
    array("poruka" => "Nema stanica.")
  );
}
