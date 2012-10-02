<?php

//besoin des variables suivantes :
/*
categories = ['Categorie1','cat2'...] 
nom principal
*/
$categories = array('MSIE','Firefox','Chrome', 'Safari', 'Opera');
$donnees_principales = array(55.11,21.63,11.94,7.15,2.14);
$titre_principal = 'Marques de navigateurs';
$nb_cat = count($categories);
$souscat1 = array('MSIE 6.0', 'MSIE 7.0', 'MSIE 8.0', 'MSIE 9.0');
$souscat1_data = array (0.20, 0.83, 1.58, 13.12, 5.43);
$souscat2 = array('Firefox 2.0', 'Firefox 3.0', 'Firefox 3.5', 'Firefox 3.6', 'Firefox 4.0');
$souscat2_data = array (10.85, 7.35, 33.06, 2.81);
$souscat3 = array('Chrome 5.0', 'Chrome 6.0', 'Chrome 7.0','Chrome 8.0', 'Chrome 9.0','Chrome 10.0', 'Chrome 11.0', 'Chrome 12.0');
$souscat3_data = array (0.12, 0.19, 0.12, 0.36, 0.32, 9.91, 0.50, 0.22);
$souscat4 = array('Safari 5.0', 'Safari 4.0', 'Safari Win 5.0', 'Safari 4.1', 'Safari/Maxthon','Safari 3.1', 'Safari 4.1');
$souscat4_data = array (4.55, 1.42, 0.23, 0.21, 0.20, 0.19, 0.14);
$souscat5 = array('MSIE 6.0', 'MSIE 7.0', 'MSIE 8.0', 'MSIE 9.0');
$souscat5_data = array (10.85, 7.35, 33.06, 2.81);

$toutes_souscat = array($souscat1,$souscat2,$souscat3,$souscat4,$souscat5);
$toutes_souscat_data = array($souscat1_data,$souscat2_data,$souscat3_data,$souscat4_data,$souscat5_data);
//$toutes_souscat_nom = array($souscat1_nom,$souscat2_nom,$souscat3_nom,$souscat4_nom,$souscat5_nom);
$toutes_souscat_nom = array('TRUC','TRUC','TRUC','TRUC','TRUC');


$graph_drilldown = array("cat" => $categories, "cat_data" => $donnees_principales, "souscat_nom" => $toutes_souscat_nom, "souscat" => $toutes_souscat, "souscat_data" => $toutes_souscat_data  );


function graph_colonnes_drilldown ($donnee_categorie,$id_categorie,$nom_souscat,$souscat=false,$souscat_data=false) {
$codejs = '{y:';
$codejs .= $donnee_categorie;
$codejs .= ",color:colors[";
$codejs .= $id_categorie;
$codejs .= "],";
	//DRILLDOWN
	if ($souscat!=false) {
		$codejs .= "drilldown:{name:'";
		$codejs .= $nom_souscat;
		$codejs .= "',categories:";
		$codejs .= json_encode($souscat);
		$codejs .= ",data:";
		$codejs .= json_encode($souscat_data);
		$codejs .= ",color:colors[";
		$codejs .= $id_categorie;
		$codejs .= "]}";
	}
$codejs .= "}" ;
return $codejs;	
}
	

echo "
$(function () {
    var chart;
    $(document).ready(function() {    
        var colors = Highcharts.getOptions().colors,
            categories = ";
			
			echo json_encode($categories); //CATEGORIES
			echo",
            name = '";
			echo $titre_principal;  //nom principal
			echo "',
            data = [";
			
			//echo graph_colonnes_drilldown($donnees_principales[0],0,'IE daube versions',$souscat1,$souscat1_data);
			
			
			for ($i = 0 , $j = count($graph_drilldown['cat']); $i < $j; $i++) {
              if ($i>0 && $i < $j) {
				  echo',';
			  }
			 echo graph_colonnes_drilldown($graph_drilldown['cat_data'][$i],$i,$graph_drilldown['souscat_nom'][$i],$graph_drilldown['souscat'][$i],$graph_drilldown['souscat_data'][$i]);
		}
				
				/*echo ", {
                    y: 21.63,
                    color: colors[1],
                    drilldown: {
                        name: 'Firefox versions',
                        categories: ['Firefox 2.0', 'Firefox 3.0', 'Firefox 3.5', 'Firefox 3.6', 'Firefox 4.0'],
                        data: [0.20, 0.83, 1.58, 13.12, 5.43],
                        color: colors[1]
                    }
                }, {
                    y: 11.94,
                    color: colors[2],
                    drilldown: {
                        name: 'Chrome versions',
                        categories: ['Chrome 5.0', 'Chrome 6.0', 'Chrome 7.0', 'Chrome 8.0', 'Chrome 9.0',
                            'Chrome 10.0', 'Chrome 11.0', 'Chrome 12.0'],
                        data: [0.12, 0.19, 0.12, 0.36, 0.32, 9.91, 0.50, 0.22],
                        color: colors[2]
                    }
                }, {
                    y: 7.15,
                    color: colors[3],
                    drilldown: {
                        name: 'Safari versions',
                        categories: ['Safari 5.0', 'Safari 4.0', 'Safari Win 5.0', 'Safari 4.1', 'Safari/Maxthon',
                            'Safari 3.1', 'Safari 4.1'],
                        data: [4.55, 1.42, 0.23, 0.21, 0.20, 0.19, 0.14],
                        color: colors[3]
                    }
                }, {
                    y: 2.14,
                    color: colors[4],
                    drilldown: {
                        name: 'Opera versions',
                        categories: ['Opera 9.x', 'Opera 10.x', 'Opera 11.x'],
                        data: [ 0.12, 0.37, 1.65],
                        color: colors[4]
                    }
                }";*/
				
			echo "];
    
        function setChart(name, categories, data, color) {
            chart.xAxis[0].setCategories(categories);
            chart.series[0].remove();
            chart.addSeries({
                name: name,
                data: data,
                color: color || 'white'
            });
        }
    
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'graph',
                type: 'column'
            },
            title: {
                text: 'Browser market share, April, 2011'
            },
            subtitle: {
                text: 'Voir les sous categories'
            },
            xAxis: {
                categories: categories
            },
            yAxis: {
                title: {
                    text: 'Total percent market share'
                }
            },
            plotOptions: {
                column: {
                    cursor: 'pointer',
                    point: {
                        events: {
                            click: function() {
                                var drilldown = this.drilldown;
                                if (drilldown) { // drill down
                                    setChart(drilldown.name, drilldown.categories, drilldown.data, drilldown.color);
                                } else { // restore
                                    setChart(name, categories, data);
                                }
                            }
                        }
                    },
                    dataLabels: {
                        enabled: true,
                        color: colors[0],
                        style: {
                            fontWeight: 'bold'
                        },
                        formatter: function() {
                            return this.y +'unité';
                        }
                    }
                }
            },
            tooltip: {
                formatter: function() {
                    var point = this.point,
                        s = this.x +':<b>'+ this.y +'calcul ou unite</b><br/>';
                    if (point.drilldown) {
                        s += 'Voir '+ point.category +' ';
                    } else {
                        s += 'Retour';
                    }
                    return s;
                }
            },
            series: [{
                name: name,
                data: data,
                color: 'white'
            }],
            exporting: {
                enabled: true
            }
        });
    });
    
});
";
?>