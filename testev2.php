<?php
$meuArray = wpgetapi_endpoint('chsa_api', 'GetTorneios', array('debug' => false));

if (empty($meuArray)) {
    echo "O array está vazio.";
} else {
    echo '<!DOCTYPE html>';
    echo '<html lang="pt-br">';
    echo '<head>';
    echo '<meta charset="UTF-8">';
    echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
    echo '<title>Eventos</title>';
    echo '<!-- Inclua o Bootstrap (caso não esteja incluído na página) -->';
    echo '<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">';
    echo '<style>';
    echo '/* Estilos CSS para o layout dos eventos */';
    echo '.event {';
    echo '    margin-bottom: 20px;';
    echo '    border: 1px solid #ddd;';
    echo '    border-radius: 5px;';
    echo '    box-shadow: 0 2px 4px rgba(0,0,0,0.1);';
    echo '}';
    echo '.card-body {';
    echo '    padding: 20px;';
    echo '}';
    echo '.card-title {';
    echo '    font-size: 18px;';
    echo '    font-weight: bold;';
    echo '    margin-bottom: 10px;';
    echo '}';
    echo '.date {';
    echo '    background-color: #f0f0f0;';
    echo '    padding: 10px;';
    echo '    text-align: center;';
    echo '    margin-bottom: 10px;';
    echo '    float: left; /* Alinha à esquerda */';
    echo '    margin-right: 10px; /* Espaçamento entre a data e o conteúdo */';
    echo '    width: 80px; /* Largura fixa para a data */';
    echo '    height: 80px; /* Altura fixa para a data */';
    echo '    border-radius: 50%; /* Formato circular */';
    echo '}';
    echo '.date .day {';
    echo '    font-size: 20px;';
    echo '    font-weight: bold;';
    echo '}';
    echo '.date .month {';
    echo '    font-size: 14px;';
    echo '    display: block;';
    echo '}';
    echo '.description {';
    echo '    text-align: right;';
    echo '}';
    echo '.description a {';
    echo '    display: inline-block;';
    echo '    padding: 10px 20px;';
    echo '    background-color: #007bff;';
    echo '    color: #fff;';
    echo '    text-decoration: none;';
    echo '    border-radius: 5px;';
    echo '}';
    echo '.description a:hover {';
    echo '    background-color: #0056b3;';
    echo '}';
    echo '</style>';
    echo '</head>';
    echo '<body>';
    echo '<div class="container">';
    echo '<h1 class="text-center">Eventos</h1>';
    echo '<div class="row">';

    $painel = array_slice($meuArray, 0, 50);
    foreach ($painel as $elemento) {
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
        
        if ($dataInicioObj == $dataFimObj) {
            echo '<div class="date">';
            echo '<span class="day">' . $diaInicio . '</span>';
            echo '<span class="month">' . $mesInicio . '</span>';
            echo '</div>';
        } else {
            echo '<div class="date">';
            echo '<span class="day">' . $diaInicio . ' a ' . $diaFim . '</span>';
            echo '<span class="month">' . $mesInicio . '</span>';
            echo '</div>';
        }
        
        echo '<h5 class="card-title">' . $elemento['DESCRICAO'] . '</h5>';
        
        echo '<div class="description">';
        echo '<a href="https://wordpress2.central.inputcenter.com.br:2080/home/lista-de-provas/?ID=' . $elemento['ID'] . '" class="btn btn-primary float-right">+</a>';
        echo '</div>';
        
        echo '</div>'; // .card-body
        echo '</div>'; // .event card
        echo '</div>'; // .col-md-6
    }

    echo '</div>'; // .row
    echo '</div>'; // .container
    echo '</body>';
    echo '</html>';
}
?>