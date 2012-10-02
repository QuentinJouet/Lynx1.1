<?php


// NOM DES X 
//$categories = array();


echo "
$(function () {
    var chart;
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'graph_colonnes_simples',
                type: 'column'
            },
            title: {
                text: 'Meilleurs ventes'
            },
            subtitle: {
                text: 'Données : Février - Avril 2012'
            },
            xAxis: {
                categories: ";
				echo json_encode($categories);
				echo "
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Chiffre d\'affaires (€)'
                }
            },
            legend: {
                layout: 'vertical',
                backgroundColor: '#FFFFFF',
                align: 'left',
                verticalAlign: 'top',
                x: 100,
                y: 70,
                floating: true,
                shadow: true
            },
            tooltip: {
                formatter: function() {
                    return ''+
                        this.x +': '+ this.y +' mm';
                }
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
                series: [{
                name: 'Chiffre d\'affaires',
                data: ";
				echo json_encode($donnees);
				echo "
            }, {
                name: 'Quantité vendues',
                data: ";
				echo json_encode($donnees_q);
				echo "
    
            },]
        });
    });
    
});
		";
		?>