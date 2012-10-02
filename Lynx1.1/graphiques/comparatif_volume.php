<?php
echo "
                   
$(function () {
    var chart;
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'chiffre_affaires',
                type: 'area'
            },
            title: {
                text: 'CA'
            },
            subtitle: {
                text: 'Source: données store-factory'
            },
            xAxis: {
                labels: {
                    formatter: function() {
                        return this.value; // clean, unformatted number for year
                    }
                }
            },
            yAxis: {
                title: {
                    text: 'CA en €'
                },
                labels: {
                    formatter: function() {
                        return this.value ;
                    }
                }
            },
            tooltip: {
                formatter: function() {
                    return this.series.name +' € <b>'+
                        Highcharts.numberFormat(this.y, 0) +'</b><br/> Jour n° '+ Math.round(this.x);
                }
            },
            plotOptions: {
                area: {
                    pointStart: ";
					echo $_SESSION['date_debut'];	
					echo ",
                    marker: {
                        enabled: false,
                        symbol: 'circle',
                        radius: 2,
                        states: {
                            hover: {
                                enabled: true
                            }
                        }
                    }
                }
            },
            series: [{
                name: 'Ventes en ligne',
                data: ";
				echo json_encode($donnees);
				echo "
            }, {
                name: 'Ventes boutique',
                data: ";
				echo json_encode($donnes_q);
				echo "
            }]
        });
    });
    
});
";