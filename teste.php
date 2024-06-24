<?php
$meuArray = wpgetapi_endpoint('chsa_api', 'GetTorneios', array('debug' => false));

// HTML e CSS para a página
echo '<!DOCTYPE html>';
echo '<html lang="pt-br">';
echo '<head>';
echo '<meta charset="UTF-8">';
echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
echo '<title>Eventos</title>';
echo '<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">';
echo '<style>';
echo '.event { margin-bottom: 20px; border: 1px solid #ddd; border-radius: 5px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }';
echo '.card-body { padding: 20px; }';
echo '.card-title { font-size: 18px; font-weight: bold; margin-bottom: 10px; }';
echo '.date { background-color: #f0f0f0; padding: 10px; text-align: center; margin-bottom: 10px; float: left; margin-right: 10px; width: 80px; height: 80px; border-radius: 50%; }';
echo '.date .day { font-size: 20px; font-weight: bold; }';
echo '.date .month { font-size: 14px; display: block; }';
echo '.description { text-align: right; }';
echo '.description a { display: inline-block; padding: 10px 20px; background-color: #007bff; color: #fff; text-decoration: none; border-radius: 5px; }';
echo '.description a:hover { background-color: #0056b3; }';
echo '</style>';
echo '</head>';
echo '<body>';
echo '<div class="container">';
echo '<h1 class="text-center">Eventos</h1>';

// Formulário de busca
echo '<form method="GET" class="mb-4">';
echo '<div class="form-row">';
echo '<div class="col-md-6 mb-3">';
echo '<input type="text" name="search_name" class="form-control" placeholder="Buscar por nome do evento">';
echo '</div>';
echo '<div class="col-md-4 mb-3">';
echo '<input type="number" name="search_year" class="form-control" placeholder="Buscar por ano">';
echo '</div>';
echo '<div class="col-md-2 mb-3">';
echo '<button type="submit" class="btn btn-primary btn-block">Buscar</button>';
echo '</div>';
echo '</div>';
echo '</form>';

if (empty($meuArray)) {
    echo "<div class='col-md-12'>Não foram encontrados eventos.</div>";
} else {
    // Filtragem dos resultados
    $search_name = isset($_GET['search_name']) ? $_GET['search_name'] : '';
    $search_year = isset($_GET['search_year']) ? $_GET['search_year'] : '';

    $filteredArray = array_filter($meuArray, function($elemento) use ($search_name, $search_year) {
        $dataInicioObj = new DateTime($elemento['DATA_INICIO']);
        $year = $dataInicioObj->format('Y');

        $matchesName = empty($search_name) || stripos($elemento['DESCRICAO'], $search_name) !== false;
        $matchesYear = empty($search_year) || $year == $search_year;

        return $matchesName && $matchesYear;
    });

    $painel = array_slice($filteredArray, 0, 50);
    echo '<div class="row">';
    foreach ($painel as $elemento) {
        // Tratamento das datas
        $dataInicioObj = new DateTime($elemento['DATA_INICIO']);
        $dataFimObj = new DateTime($elemento['DATA_FIM']);

        $diaInicio = $dataInicioObj->format('d');
        $mesInicio = strftime('%b', strtotime($elemento['DATA_INICIO']));

        $diaFim = $dataFimObj->format('d');
        $mesFim = strftime('%b', strtotime($elemento['DATA_FIM']));

        // Ajustando o nome do mês para português
        $meses = array(
            "Jan" => "Jan", "Feb" => "Fev", "Mar" => "Mar", "Apr" => "Abr", "May" => "Mai", "Jun" => "Jun",
            "Jul" => "Jul", "Aug" => "Ago", "Sep" => "Set", "Oct" => "Out", "Nov" => "Nov", "Dec" => "Dez"
        );
        $mesInicio = $meses[$mesInicio];
        $mesFim = $meses[$mesFim];

        echo '<div class="col-md-6">';
        echo '<div class="event card">';
        echo '<div class="card-body">';

        echo '<div class="date">';
        echo '<span class="day">' . $diaInicio . ' a ' . $diaFim . '</span>';
        echo '<span class="month">' . $mesInicio . '</span>';
        echo '</div>';

        echo '<h5 class="card-title">' . $elemento['DESCRICAO'] . '</h5>';

        echo '<div class="description">';
        echo '<a href="https://wordpress2.central.inputcenter.com.br:2080/home/lista-de-provas/?ID=' . $elemento['ID'] . '" class="btn btn-primary float-right">+</a>';
        echo '</div>';

        echo '</div>'; // .card-body
        echo '</div>'; // .event card
        echo '</div>'; // .col-md-6
    }
    echo '</div>'; // .row
}

echo '</div>'; // .container
echo '</body>';
echo '</html>';
?>