<?php
class GraphSplines extends Graph {
	
	//GRAPH POUR LES NIVEAUX DE STOCKS.
	
	//Exemple de container : <div id="container" style="min-width: 400px; height: 400px; margin: 0 auto"></div>
	
	public $titre='Titre';
	public $soustitre='Evolution des stocks';
	public $id_container='container';
	public $stock_securite=1;
	public $stock_cible=20;
	public $stock_seuil=5;
	public $datedebut;
	public $datefin;
	public $style_container='min-width: 400px; height: 400px; margin: 0 auto';
	public $serie_internet;
	public $serie_boutique;
	
	public function __construct(){
		global $session;
		$this->datedebut=$session->datedebut->timestamp;
		$this->datefin=$session->datefin->timestamp;
	}
	
	public function renseigner($id_produit){
		$produit=Produit::produit_par_id($id_produit);
		$this->serie_internet=$produit->historique('web');
		$this->serie_boutique=$produit->historique('boutique');
		$this->titre=utf8_encode($produit->titre);
		$this->stock_securite = $produit->stock_securite; 
		$this->stock_seuil = $produit->stock_seuil; 
		$this->stock_cible = $produit->stock_cible; 
	}
	
	
	public function renseigner_general(){
		
	}
		
	
	public function container(){
		$container = '<div id=".$this->id_container." style="'.$this->style_container.'"></div>';
		return $container;
	}
	
	public function generer(){
		$code= "
<script type=\"text/javascript\">	
$(function () {
    var chart;
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: {
                renderTo: '{$this->id_container}',
                 zoomType: 'x',
                type: 'spline'
            },
            title: {
                text: '{$this->titre}'
            },
            subtitle: {
                text: '{$this->soustitre}'
            },
            xAxis: {
                type: 'datetime'
            },
            yAxis: {
                title: {
                    text: 'Stocks (unités)'
                },
                min: 0,
                minorGridLineWidth: 0,
                gridLineWidth: 0,
                alternateGridColor: null,
                plotBands: [{ // Stock de sécurité
                    from: 0,
                    to: {$this->stock_securite},
                    color: 'rgba(68, 170, 213, 0.1)',
                    label: {
                        text: 'Stock de sécurité',
                        style: {
                            color: '#606060'
                        }
                    }
                }, { // Seuil de commande
                    from: {$this->stock_securite},
                    to: {$this->stock_seuil},
                    color: 'rgba(0, 0, 0, 0)',
                    label: {
                        text: 'Seuil de commande',
                        style: {
                            color: '#606060'
                        }
                    }
                }, { // Stock cible
                    from: {$this->stock_seuil},
                    to: {$this->stock_cible},
                    color: 'rgba(68, 170, 213, 0.1)',
                    label: {
                        text: 'Stock Cible',
                        style: {
                            color: '#606060'
                        }
                    }
                }, { // Surstock
                    from: {$this->stock_cible},
                    to: (2*{$this->stock_cible}),
                    color: 'rgba(0, 0, 0, 0)',
                    label: {
                        text: '',
                        style: {
                            color: '#606060'
                        }
                    }
                }, { // Surstock
                    from: (2*{$this->stock_cible}),
                    to: (3*{$this->stock_cible}),
                    color: 'rgba(0, 0, 0, 0)',
                    label: {
                        text: 'Surstock',
                        style: {
                            color: '#606060'
                        }
                    }
                }]
            },
            tooltip: {
                formatter: function() {
                        return ''+
                        Highcharts.dateFormat('%e. %b %Y', this.x) +': '+ this.y ;
                }
            },
            plotOptions: {
                spline: {
                    lineWidth: 4,
                    states: {
                        hover: {
                            lineWidth: 5
                        }
                    },
                    marker: {
                        enabled: false,
                        states: {
                            hover: {
                                enabled: true,
                                symbol: 'circle',
                                radius: 5,
                                lineWidth: 1
                            }
                        }
                    },
                    //pointInterval: (3600000*24), // un jour
                    //pointStart: {$this->datedebut}
                }
            },
            series: [{
                name: 'Stock Internet',
                data: {$this->serie_internet}    
            }, {
                name: 'Stock Boutique',
                data: {$this->serie_boutique}
            }]
            ,
            navigation: {
                menuItemStyle: {
                    fontSize: '10px'
                }
            }
        });
    });
    
});
		</script>

	";
	return $code;
}	
	
	public function generer_alter(){
	$code="<script type=\"text/javascript\">
$(function () {
    var chart;
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: {
                renderTo: '{$this->id_container}',
                
                type: 'spline'
            },
            title: {
                text: '{$this->titre}'
            },
            subtitle: {
                text: '{$this->soustitre}'
            },
            xAxis: {
                type: 'datetime',
                dateTimeLabelFormats: { // don't display the dummy year
                    month: '%e. %b',
                    year: '%b'
                }
            },
            yAxis: {
                title: {
                    text: 'Stocks (unité)'
                },
                min: 0
            },
            tooltip: {
                formatter: function() {
                        return '<b>'+ this.series.name +'</b><br/>'+
                        Highcharts.dateFormat('%e. %b', this.x) +': '+ this.y +' m';
                }
            },
            
            series: [{
                name: 'Stock internet',

                data: {$this->serie_internet}            }, {
                name: 'Stock boutique',
                data: {$this->serie_boutique}
                
            }]
        });
    });
    
});
";
return $code;
	}

	
	
}

?>