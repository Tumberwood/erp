<?php
	include( "../../../../users/init.php" );
	include( "../../../../usersc/lib/DataTables.php" );
	
	use
		DataTables\Editor,
		DataTables\Editor\Field,
		DataTables\Editor\Format,
		DataTables\Editor\Mjoin,
		DataTables\Editor\Options,
		DataTables\Editor\Upload,
		DataTables\Editor\Validate,
		DataTables\Editor\ValidateOptions,
		DataTables\Editor\Query,
		DataTables\Editor\Result;
	
        $sql_select = $db
        ->raw()
		->bind(':id_hrctstd_kostik', $_GET['id_hrctstd_kostik'])
		->exec('SELECT
                    a.N AS N,
                    a.G AS G,
                    a.A AS A,
                    a.L AS L,
                    a.P AS P,
                    a.I AS I,
                    a.T AS T,
                    a.V AS V,
                    a.X AS X,
                    a.S AS S,
                    a.B AS B,
                    a.O AS O,
                    a.R AS R,
                    a.D AS D,
                    a.C AS C,
                    a.Z AS Z,
                    a.E AS E,
                    a.K AS K,
                    a.F AS F,
                    a.W AS W,
                    a.work_direction AS work_direction,
                    a.leadership AS leadership,
                    a.activiti AS activiti,
                    a.social_nature AS social_nature,
                    a.work_style AS work_style,
                    a.temprament AS temprament,
                    a.follower AS follower,
                    c.nama as peg
                FROM hrctstd_kostik AS a
                LEFT JOIN hrctsth_kostik as b on b.id = a.id_hrctsth_kostik
                LEFT JOIN hcdxxmh as c on c.id = b.id_hcdxxmh
				WHERE a.id = :id_hrctstd_kostik'
				);
	    $results_select = $sql_select->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Tabel Hasil Tes Papi Kostik</title>
</head>
<body>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

<style>
    .biru {
        color: white;
        background-color: rgb(0, 32, 96);
        ;
    }

    .kuning {
        color: black;
        background-color: rgb(255, 255, 0);
    }

    td[rowspan] {
        text-align: center;
        font-weight: bold;
        vertical-align: middle;
        font-size: 20px; 
    }

    /* Style <td> and <th> elements */
    table td,
    table th,
    table tr {
        border: 1px solid black;
        padding: 5px; /* Set the border width and color for <tr> */
    }

    .code{
        text-align: center;
        color: white;
        background-color: rgb(255, 0, 0);
    }

</style>
<h5 class="text-center">Hasil Tes Papi Kostik <?php echo $results_select['peg'] ?> </h5>
<!-- <h6 class="text-center"><?php echo $results_select['peg'] ?> </h6> -->
<div class="container mt-4 d-flex justify-content-center align-items-center">
    <table>
        <thead>
            <tr>
                <th colspan="3" class="text-center" style="color: white; background-color: black; font-size: 20px">PARAMETER</th>
                <th>CODE</th>
                <th colspan="2" class="text-center code">SCORE</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td rowspan="3" style="font-size: 30px;" class="biru">WORK DIRECTION</td>
                <td class="biru">Need to Personality Finish a Task</td>
                <td>HIGH ANALYSIS</td>
                <td class="code">N</td>
                <?php
                    if ($results_select['N'] < 3) {
                        echo '<td><i class="fas fa-arrow-down text-danger"></i> ' . $results_select['N'] . "</td>";
                    } else if ($results_select['N'] >= 3 && $results_select['N'] < 5) {
                        echo '<td><i class="fas fa-arrow-up text-warning" style="transform: rotate(135deg)"></i> ' . $results_select['N'] . "</td>";
                    } else if ($results_select['N'] >= 5 && $results_select['N'] < 7) {
                        echo '<td><i class="fas fa-arrow-up text-warning" style="transform: rotate(45deg)"></i> ' . $results_select['N'] . "</td>";
                    } else {
                        echo '<td><i class="fas fa-arrow-up text-success" ></i> ' . $results_select['N'] . "</td>";
                    }

                    if ($results_select['work_direction'] < 2.5) {
                        echo '<td rowspan="3" style="font-size: 30px;"><i class="fas fa-arrow-down text-danger"></i> ' . $results_select['work_direction'] . "</td>";
                    } else if ($results_select['work_direction'] >= 2.5 && $results_select['work_direction'] < 4) {
                        echo '<td rowspan="3" style="font-size: 30px;"><i class="fas fa-arrow-up text-warning" style="transform: rotate(135deg)"></i> ' . $results_select['work_direction'] . "</td>";
                    } else if ($results_select['work_direction'] >= 4 && $results_select['work_direction'] < 5.5) {
                        echo '<td rowspan="3" style="font-size: 30px;"><i class="fas fa-arrow-up text-warning" style="transform: rotate(45deg)"></i> ' . $results_select['work_direction'] . "</td>";
                    } else {
                        echo '<td rowspan="3" style="font-size: 30px;"><i class="fas fa-arrow-up text-success" ></i> ' . $results_select['work_direction'] . "</td>";
                    }

                    
                ?>
            </tr>

            <tr>
                <td class="biru">Role of hard intense worker</td>
                <td>LOW ANALISYS</td>
                <td class="code">G</td>
                <?php
                    if ($results_select['G'] < 3) {
                        echo '<td><i class="fas fa-arrow-down text-danger"></i> ' . $results_select['G'] . "</td>";
                    } else if ($results_select['G'] >= 3 && $results_select['G'] < 5) {
                        echo '<td><i class="fas fa-arrow-up text-warning" style="transform: rotate(135deg)"></i> ' . $results_select['G'] . "</td>";
                    } else if ($results_select['G'] >= 5 && $results_select['G'] < 7) {
                        echo '<td><i class="fas fa-arrow-up text-warning" style="transform: rotate(45deg)"></i> ' . $results_select['G'] . "</td>";
                    } else {
                        echo '<td><i class="fas fa-arrow-up text-success" ></i> ' . $results_select['G'] . "</td>";
                    }
                ?>
            </tr>
            <tr>
                <td class="biru">Need to Achieve</td>
                <td>HIGH ANALISYS</td>
                <td class="code">A</td>
                <?php
                    if ($results_select['A'] < 3) {
                        echo '<td><i class="fas fa-arrow-down text-danger"></i> ' . $results_select['A'] . "</td>";
                    } else if ($results_select['A'] >= 3 && $results_select['A'] < 5) {
                        echo '<td><i class="fas fa-arrow-up text-warning" style="transform: rotate(135deg)"></i> ' . $results_select['A'] . "</td>";
                    } else if ($results_select['A'] >= 5 && $results_select['A'] < 7) {
                        echo '<td><i class="fas fa-arrow-up text-warning" style="transform: rotate(45deg)"></i> ' . $results_select['A'] . "</td>";
                    } else {
                        echo '<td><i class="fas fa-arrow-up text-success" ></i> ' . $results_select['A'] . "</td>";
                    }
                ?>
            </tr>
            <tr>
                <td rowspan="3" style="font-size: 30px;" class="kuning">LEADERSHIP</td>
                <td class="kuning">Leadership Role</td>
                <td>LOW ANALISYS</td>
                <td class="code">L</td>
                <?php
                    if ($results_select['L'] < 3) {
                        echo '<td><i class="fas fa-arrow-down text-danger"></i> ' . $results_select['L'] . "</td>";
                    } else if ($results_select['L'] >= 3 && $results_select['L'] < 5) {
                        echo '<td><i class="fas fa-arrow-up text-warning" style="transform: rotate(135deg)"></i> ' . $results_select['L'] . "</td>";
                    } else if ($results_select['L'] >= 5 && $results_select['L'] < 7) {
                        echo '<td><i class="fas fa-arrow-up text-warning" style="transform: rotate(45deg)"></i> ' . $results_select['L'] . "</td>";
                    } else {
                        echo '<td><i class="fas fa-arrow-up text-success" ></i> ' . $results_select['L'] . "</td>";
                    }
                    
                    if ($results_select['leadership'] < 2.5) {
                        echo '<td rowspan="3" style="font-size: 30px;"><i class="fas fa-arrow-down text-danger"></i> ' . $results_select['leadership'] . "</td>";
                    } else if ($results_select['leadership'] >= 2.5 && $results_select['leadership'] < 4) {
                        echo '<td rowspan="3" style="font-size: 30px;"><i class="fas fa-arrow-up text-warning" style="transform: rotate(135deg)"></i> ' . $results_select['leadership'] . "</td>";
                    } else if ($results_select['leadership'] >= 4 && $results_select['leadership'] < 5.5) {
                        echo '<td rowspan="3" style="font-size: 30px;"><i class="fas fa-arrow-up text-warning" style="transform: rotate(45deg)"></i> ' . $results_select['leadership'] . "</td>";
                    } else {
                        echo '<td rowspan="3" style="font-size: 30px;"><i class="fas fa-arrow-up text-success" ></i> ' . $results_select['leadership'] . "</td>";
                    }
                ?>
            </tr>
            <tr>
                <td class="kuning">Need to Control Others</td>
                <td>HIGH ANALISYS</td>
                <td class="code">P</td>
                <?php
                    if ($results_select['P'] < 3) {
                        echo '<td><i class="fas fa-arrow-down text-danger"></i> ' . $results_select['P'] . "</td>";
                    } else if ($results_select['P'] >= 3 && $results_select['P'] < 5) {
                        echo '<td><i class="fas fa-arrow-up text-warning" style="transform: rotate(135deg)"></i> ' . $results_select['P'] . "</td>";
                    } else if ($results_select['P'] >= 5 && $results_select['P'] < 7) {
                        echo '<td><i class="fas fa-arrow-up text-warning" style="transform: rotate(45deg)"></i> ' . $results_select['P'] . "</td>";
                    } else {
                        echo '<td><i class="fas fa-arrow-up text-success" ></i> ' . $results_select['P'] . "</td>";
                    }
                ?>
            </tr>
            <tr>
                <td class="kuning">Ease in Decision Making</td>
                <td>LOW ANALISYS</td>
                <td class="code">I</td>
                <?php
                    if ($results_select['I'] < 3) {
                        echo '<td><i class="fas fa-arrow-down text-danger"></i> ' . $results_select['I'] . "</td>";
                    } else if ($results_select['I'] >= 3 && $results_select['I'] < 5) {
                        echo '<td><i class="fas fa-arrow-up text-warning" style="transform: rotate(135deg)"></i> ' . $results_select['I'] . "</td>";
                    } else if ($results_select['I'] >= 5 && $results_select['I'] < 7) {
                        echo '<td><i class="fas fa-arrow-up text-warning" style="transform: rotate(45deg)"></i> ' . $results_select['I'] . "</td>";
                    } else {
                        echo '<td><i class="fas fa-arrow-up text-success" ></i> ' . $results_select['I'] . "</td>";
                    }
                ?>
            </tr>
            <tr>
                <td rowspan="2" class="biru">ACTIVITY</td>
                <td class="biru">"On The Go" Type</td>
                <td>LOW ANALISYS</td>
                <td class="code">T</td>
                <?php
                    if ($results_select['T'] < 3) {
                        echo '<td><i class="fas fa-arrow-down text-danger"></i> ' . $results_select['T'] . "</td>";
                    } else if ($results_select['T'] >= 3 && $results_select['T'] < 5) {
                        echo '<td><i class="fas fa-arrow-up text-warning" style="transform: rotate(135deg)"></i> ' . $results_select['T'] . "</td>";
                    } else if ($results_select['T'] >= 5 && $results_select['T'] < 7) {
                        echo '<td><i class="fas fa-arrow-up text-warning" style="transform: rotate(45deg)"></i> ' . $results_select['T'] . "</td>";
                    } else {
                        echo '<td><i class="fas fa-arrow-up text-success" ></i> ' . $results_select['T'] . "</td>";
                    }
                    
                    if ($results_select['activiti'] < 2.5) {
                        echo '<td rowspan="2" style="font-size: 30px;"><i class="fas fa-arrow-down text-danger"></i> ' . $results_select['activiti'] . "</td>";
                    } else if ($results_select['activiti'] >= 2.5 && $results_select['activiti'] < 4) {
                        echo '<td rowspan="2" style="font-size: 30px;"><i class="fas fa-arrow-up text-warning" style="transform: rotate(135deg)"></i> ' . $results_select['activiti'] . "</td>";
                    } else if ($results_select['activiti'] >= 4 && $results_select['activiti'] < 5.5) {
                        echo '<td rowspan="2" style="font-size: 30px;"><i class="fas fa-arrow-up text-warning" style="transform: rotate(45deg)"></i> ' . $results_select['activiti'] . "</td>";
                    } else {
                        echo '<td rowspan="2" style="font-size: 30px;"><i class="fas fa-arrow-up text-success" ></i> ' . $results_select['activiti'] . "</td>";
                    }
                ?>
            </tr>
            <tr>
                <td class="biru">Vigorous Type</td>
                <td>MIDDLE RANGE</td>
                <td class="code">V</td>
                <?php
                    if ($results_select['V'] < 3) {
                        echo '<td><i class="fas fa-arrow-down text-danger"></i> ' . $results_select['V'] . "</td>";
                    } else if ($results_select['V'] >= 3 && $results_select['V'] < 5) {
                        echo '<td><i class="fas fa-arrow-up text-warning" style="transform: rotate(135deg)"></i> ' . $results_select['V'] . "</td>";
                    } else if ($results_select['V'] >= 5 && $results_select['V'] < 7) {
                        echo '<td><i class="fas fa-arrow-up text-warning" style="transform: rotate(45deg)"></i> ' . $results_select['V'] . "</td>";
                    } else {
                        echo '<td><i class="fas fa-arrow-up text-success" ></i> ' . $results_select['V'] . "</td>";
                    }
                ?>
            </tr>
            <tr>
                <td rowspan="4" class="kuning">SOCIAL NATURE</td>
                <td class="kuning">Need to be Noticed</td>
                <td>MIDDLE RANGE</td>
                <td class="code">X</td>
                <?php
                    if ($results_select['X'] < 3) {
                        echo '<td><i class="fas fa-arrow-down text-danger"></i> ' . $results_select['X'] . "</td>";
                    } else if ($results_select['X'] >= 3 && $results_select['X'] < 5) {
                        echo '<td><i class="fas fa-arrow-up text-warning" style="transform: rotate(135deg)"></i> ' . $results_select['X'] . "</td>";
                    } else if ($results_select['X'] >= 5 && $results_select['X'] < 7) {
                        echo '<td><i class="fas fa-arrow-up text-warning" style="transform: rotate(45deg)"></i> ' . $results_select['X'] . "</td>";
                    } else {
                        echo '<td><i class="fas fa-arrow-up text-success" ></i> ' . $results_select['X'] . "</td>";
                    }
                    
                    if ($results_select['social_nature'] < 2.5) {
                        echo '<td rowspan="4" style="font-size: 30px;"><i class="fas fa-arrow-down text-danger"></i> ' . $results_select['social_nature'] . "</td>";
                    } else if ($results_select['social_nature'] >= 2.5 && $results_select['social_nature'] < 4) {
                        echo '<td rowspan="4" style="font-size: 30px;"><i class="fas fa-arrow-up text-warning" style="transform: rotate(135deg)"></i> ' . $results_select['social_nature'] . "</td>";
                    } else if ($results_select['social_nature'] >= 4 && $results_select['social_nature'] < 5.5) {
                        echo '<td rowspan="4" style="font-size: 30px;"><i class="fas fa-arrow-up text-warning" style="transform: rotate(45deg)"></i> ' . $results_select['social_nature'] . "</td>";
                    } else {
                        echo '<td rowspan="4" style="font-size: 30px;"><i class="fas fa-arrow-up text-success" ></i> ' . $results_select['social_nature'] . "</td>";
                    }
                ?>
            </tr>
            <tr>
                <td class="kuning">Social Extension</td>
                <td>MIDDLE RANGE </td>
                <td class="code">S</td>
                <?php
                    if ($results_select['S'] < 3) {
                        echo '<td><i class="fas fa-arrow-down text-danger"></i> ' . $results_select['S'] . "</td>";
                    } else if ($results_select['S'] >= 3 && $results_select['S'] < 5) {
                        echo '<td><i class="fas fa-arrow-up text-warning" style="transform: rotate(135deg)"></i> ' . $results_select['S'] . "</td>";
                    } else if ($results_select['S'] >= 5 && $results_select['S'] < 7) {
                        echo '<td><i class="fas fa-arrow-up text-warning" style="transform: rotate(45deg)"></i> ' . $results_select['S'] . "</td>";
                    } else {
                        echo '<td><i class="fas fa-arrow-up text-success" ></i> ' . $results_select['S'] . "</td>";
                    }
                ?>
            </tr>
            <tr>
                <td class="kuning">Need to Belong to Group</td>
                <td>MIDDLE RANGE</td>
                <td class="code">B</td>
                <?php
                    if ($results_select['B'] < 3) {
                        echo '<td><i class="fas fa-arrow-down text-danger"></i> ' . $results_select['B'] . "</td>";
                    } else if ($results_select['B'] >= 3 && $results_select['B'] < 5) {
                        echo '<td><i class="fas fa-arrow-up text-warning" style="transform: rotate(135deg)"></i> ' . $results_select['B'] . "</td>";
                    } else if ($results_select['B'] >= 5 && $results_select['B'] < 7) {
                        echo '<td><i class="fas fa-arrow-up text-warning" style="transform: rotate(45deg)"></i> ' . $results_select['B'] . "</td>";
                    } else {
                        echo '<td><i class="fas fa-arrow-up text-success" ></i> ' . $results_select['B'] . "</td>";
                    }
                ?>
            </tr>
            <tr>
                <td class="kuning">Need for closeness and affection</td>
                <td>MIDDLE RANGE</td>
                <td class="code">O</td>
                <?php
                    if ($results_select['O'] < 3) {
                        echo '<td><i class="fas fa-arrow-down text-danger"></i> ' . $results_select['O'] . "</td>";
                    } else if ($results_select['O'] >= 3 && $results_select['O'] < 5) {
                        echo '<td><i class="fas fa-arrow-up text-warning" style="transform: rotate(135deg)"></i> ' . $results_select['O'] . "</td>";
                    } else if ($results_select['O'] >= 5 && $results_select['O'] < 7) {
                        echo '<td><i class="fas fa-arrow-up text-warning" style="transform: rotate(45deg)"></i> ' . $results_select['O'] . "</td>";
                    } else {
                        echo '<td><i class="fas fa-arrow-up text-success" ></i> ' . $results_select['O'] . "</td>";
                    }
                ?>
            </tr>
            <tr>
                <td rowspan="3" style="font-size: 30px;" class="biru">WORK STYLE</td>
                <td class="biru">Theoretical type</td>
                <td>MIDDLE RANGE</td>
                <td class="code">R</td>
                <?php
                    if ($results_select['R'] < 3) {
                        echo '<td><i class="fas fa-arrow-down text-danger"></i> ' . $results_select['R'] . "</td>";
                    } else if ($results_select['R'] >= 3 && $results_select['R'] < 5) {
                        echo '<td><i class="fas fa-arrow-up text-warning" style="transform: rotate(135deg)"></i> ' . $results_select['R'] . "</td>";
                    } else if ($results_select['R'] >= 5 && $results_select['R'] < 7) {
                        echo '<td><i class="fas fa-arrow-up text-warning" style="transform: rotate(45deg)"></i> ' . $results_select['R'] . "</td>";
                    } else {
                        echo '<td><i class="fas fa-arrow-up text-success" ></i> ' . $results_select['R'] . "</td>";
                    }
                    
                    if ($results_select['work_style'] < 2.5) {
                        echo '<td rowspan="3" style="font-size: 30px;"><i class="fas fa-arrow-down text-danger"></i> ' . $results_select['work_style'] . "</td>";
                    } else if ($results_select['work_style'] >= 2.5 && $results_select['work_style'] < 4) {
                        echo '<td rowspan="3" style="font-size: 30px;"><i class="fas fa-arrow-up text-warning" style="transform: rotate(135deg)"></i> ' . $results_select['work_style'] . "</td>";
                    } else if ($results_select['work_style'] >= 4 && $results_select['work_style'] < 5.5) {
                        echo '<td rowspan="3" style="font-size: 30px;"><i class="fas fa-arrow-up text-warning" style="transform: rotate(45deg)"></i> ' . $results_select['work_style'] . "</td>";
                    } else {
                        echo '<td rowspan="3" style="font-size: 30px;"><i class="fas fa-arrow-up text-success" ></i> ' . $results_select['work_style'] . "</td>";
                    }
                ?>
            </tr>
            <tr>
                <td class="biru">Interest in working with details</td>
                <td>HIGH ANALISYS</td>
                <td class="code">D</td>
                <?php
                    if ($results_select['D'] < 3) {
                        echo '<td><i class="fas fa-arrow-down text-danger"></i> ' . $results_select['D'] . "</td>";
                    } else if ($results_select['D'] >= 3 && $results_select['D'] < 5) {
                        echo '<td><i class="fas fa-arrow-up text-warning" style="transform: rotate(135deg)"></i> ' . $results_select['D'] . "</td>";
                    } else if ($results_select['D'] >= 5 && $results_select['D'] < 7) {
                        echo '<td><i class="fas fa-arrow-up text-warning" style="transform: rotate(45deg)"></i> ' . $results_select['D'] . "</td>";
                    } else {
                        echo '<td><i class="fas fa-arrow-up text-success" ></i> ' . $results_select['D'] . "</td>";
                    }
                ?>
            </tr>
            <tr>
                <td class="biru">Organized type</td>
                <td>HIGH ANALISYS</td>
                <td class="code">C</td>
                <?php
                    if ($results_select['C'] < 3) {
                        echo '<td><i class="fas fa-arrow-down text-danger"></i> ' . $results_select['C'] . "</td>";
                    } else if ($results_select['C'] >= 3 && $results_select['C'] < 5) {
                        echo '<td><i class="fas fa-arrow-up text-warning" style="transform: rotate(135deg)"></i> ' . $results_select['C'] . "</td>";
                    } else if ($results_select['C'] >= 5 && $results_select['C'] < 7) {
                        echo '<td><i class="fas fa-arrow-up text-warning" style="transform: rotate(45deg)"></i> ' . $results_select['C'] . "</td>";
                    } else {
                        echo '<td><i class="fas fa-arrow-up text-success" ></i> ' . $results_select['C'] . "</td>";
                    }
                ?>
            </tr>
            <tr>
                <td rowspan="3" style="font-size: 30px;" class="kuning">TEMPERAMENT</td>
                <td class="kuning">Need for change</td>
                <td>LOW ANALISYS</td>
                <td class="code">Z</td>
                <?php
                    if ($results_select['Z'] < 3) {
                        echo '<td><i class="fas fa-arrow-down text-danger"></i> ' . $results_select['Z'] . "</td>";
                    } else if ($results_select['Z'] >= 3 && $results_select['Z'] < 5) {
                        echo '<td><i class="fas fa-arrow-up text-warning" style="transform: rotate(135deg)"></i> ' . $results_select['Z'] . "</td>";
                    } else if ($results_select['Z'] >= 5 && $results_select['Z'] < 7) {
                        echo '<td><i class="fas fa-arrow-up text-warning" style="transform: rotate(45deg)"></i> ' . $results_select['Z'] . "</td>";
                    } else {
                        echo '<td><i class="fas fa-arrow-up text-success" ></i> ' . $results_select['Z'] . "</td>";
                    }
                    
                    if ($results_select['temprament'] < 2.5) {
                        echo '<td rowspan="3" style="font-size: 30px;"><i class="fas fa-arrow-down text-danger"></i> ' . $results_select['temprament'] . "</td>";
                    } else if ($results_select['temprament'] >= 2.5 && $results_select['temprament'] < 4) {
                        echo '<td rowspan="3" style="font-size: 30px;"><i class="fas fa-arrow-up text-warning" style="transform: rotate(135deg)"></i> ' . $results_select['temprament'] . "</td>";
                    } else if ($results_select['temprament'] >= 4 && $results_select['temprament'] < 5.5) {
                        echo '<td rowspan="3" style="font-size: 30px;"><i class="fas fa-arrow-up text-warning" style="transform: rotate(45deg)"></i> ' . $results_select['temprament'] . "</td>";
                    } else {
                        echo '<td rowspan="3" style="font-size: 30px;"><i class="fas fa-arrow-up text-success" ></i> ' . $results_select['temprament'] . "</td>";
                    }
                ?>
            </tr>
            <tr>
                <td class="kuning">Emotional restraint</td>
                <td>HIGH ANALISYS</td>
                <td class="code">E</td>
                <?php
                    if ($results_select['E'] < 3) {
                        echo '<td><i class="fas fa-arrow-down text-danger"></i> ' . $results_select['E'] . "</td>";
                    } else if ($results_select['E'] >= 3 && $results_select['E'] < 5) {
                        echo '<td><i class="fas fa-arrow-up text-warning" style="transform: rotate(135deg)"></i> ' . $results_select['E'] . "</td>";
                    } else if ($results_select['E'] >= 5 && $results_select['E'] < 7) {
                        echo '<td><i class="fas fa-arrow-up text-warning" style="transform: rotate(45deg)"></i> ' . $results_select['E'] . "</td>";
                    } else {
                        echo '<td><i class="fas fa-arrow-up text-success" ></i> ' . $results_select['E'] . "</td>";
                    }
                ?>
            </tr>
            <tr>
                <td class="kuning">Need for Defensive Aggressiveness</td>
                <td>LOW ANALISYS</td>
                <td class="code">K</td>
                <?php
                    if ($results_select['K'] < 3) {
                        echo '<td><i class="fas fa-arrow-down text-danger"></i> ' . $results_select['K'] . "</td>";
                    } else if ($results_select['K'] >= 3 && $results_select['K'] < 5) {
                        echo '<td><i class="fas fa-arrow-up text-warning" style="transform: rotate(135deg)"></i> ' . $results_select['K'] . "</td>";
                    } else if ($results_select['K'] >= 5 && $results_select['K'] < 7) {
                        echo '<td><i class="fas fa-arrow-up text-warning" style="transform: rotate(45deg)"></i> ' . $results_select['K'] . "</td>";
                    } else {
                        echo '<td><i class="fas fa-arrow-up text-success" ></i> ' . $results_select['K'] . "</td>";
                    }
                ?>
            </tr>
            <tr>
                <td rowspan="2" class="biru">FOLLOWERSHIP</td>
                <td class="biru">Need to support authority</td>
                <td>LOW ANALISYS</td>
                <td class="code">F</td>
                <?php
                    if ($results_select['F'] < 3) {
                        echo '<td><i class="fas fa-arrow-down text-danger"></i> ' . $results_select['F'] . "</td>";
                    } else if ($results_select['F'] >= 3 && $results_select['F'] < 5) {
                        echo '<td><i class="fas fa-arrow-up text-warning" style="transform: rotate(135deg)"></i> ' . $results_select['F'] . "</td>";
                    } else if ($results_select['F'] >= 5 && $results_select['F'] < 7) {
                        echo '<td><i class="fas fa-arrow-up text-warning" style="transform: rotate(45deg)"></i> ' . $results_select['F'] . "</td>";
                    } else {
                        echo '<td><i class="fas fa-arrow-up text-success" ></i> ' . $results_select['F'] . "</td>";
                    }
                    
                    if ($results_select['follower'] < 2.5) {
                        echo '<td rowspan="2" style="font-size: 30px;"><i class="fas fa-arrow-down text-danger"></i> ' . $results_select['follower'] . "</td>";
                    } else if ($results_select['follower'] >= 2.5 && $results_select['follower'] < 4) {
                        echo '<td rowspan="2" style="font-size: 30px;"><i class="fas fa-arrow-up text-warning" style="transform: rotate(135deg)"></i> ' . $results_select['follower'] . "</td>";
                    } else if ($results_select['follower'] >= 4 && $results_select['follower'] < 5.5) {
                        echo '<td rowspan="2" style="font-size: 30px;"><i class="fas fa-arrow-up text-warning" style="transform: rotate(45deg)"></i> ' . $results_select['follower'] . "</td>";
                    } else {
                        echo '<td rowspan="2" style="font-size: 30px;"><i class="fas fa-arrow-up text-success" ></i> ' . $results_select['follower'] . "</td>";
                    }
                ?>
            </tr>
            <tr>
                <td class="biru">Need for rule and supervision</td>
                <td>LOW ANALISYS</td>
                <td class="code">W</td>
                <?php
                    if ($results_select['W'] < 3) {
                        echo '<td><i class="fas fa-arrow-down text-danger"></i> ' . $results_select['W'] . "</td>";
                    } else if ($results_select['W'] >= 3 && $results_select['W'] < 5) {
                        echo '<td><i class="fas fa-arrow-up text-warning" style="transform: rotate(135deg)"></i> ' . $results_select['W'] . "</td>";
                    } else if ($results_select['W'] >= 5 && $results_select['W'] < 7) {
                        echo '<td><i class="fas fa-arrow-up text-warning" style="transform: rotate(45deg)"></i> ' . $results_select['W'] . "</td>";
                    } else {
                        echo '<td><i class="fas fa-arrow-up text-success" ></i> ' . $results_select['W'] . "</td>";
                    }
                ?>
            </tr>
        </tbody>
    </table>
</div>
<br>
</body>
</html>
