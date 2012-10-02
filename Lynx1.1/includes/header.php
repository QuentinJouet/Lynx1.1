<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<link type="text/css" rel="stylesheet" href="stylesheets/foundation.css">
<link type="text/css" rel="stylesheet" href="stylesheets/app.css">
<link type="text/css" rel="stylesheet" href="stylesheets/custom.css">
<link type="text/css" rel="stylesheet" href="stylesheets/jqueryui.css">
<link type="text/css" rel="stylesheet" href="stylesheets/jquery.dataTables.css">


<script type="text/javascript" src="http://code.anotherwayin.fr/js/foundation3/modernizr.foundation.js"></script>
<script type="text/javascript" src="http://code.anotherwayin.fr/js/foundation3/foundation.js"></script>
<script type="text/javascript" src="http://code.anotherwayin.fr/js/foundation3/app.js"></script>
<script type="text/javascript" src="http://code.anotherwayin.fr/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="http://code.anotherwayin.fr/js/jquery-ui-1.8.20.custom.min.js"></script>
<script type="text/javascript" src="http://code.anotherwayin.fr/js/graph.js"></script>
<script type="text/javascript" src="http://code.anotherwayin.fr/js/graph_export.js"></script>
<script type="text/javascript" src="<?php echo URL_SITE;?>javascripts/jquery.dataTables.min.js"></script>

    	<script type="text/javascript" >

	$(function() {
		$( "#date_debut" ).datepicker({
			defaultDate: "-4w",
			changeMonth: true,
			numberOfMonths: 3,
			onSelect: function( selectedDate ) {
				$( "#to" ).datepicker( "option", "minDate", selectedDate );
			}
		});
		$( "#date_fin" ).datepicker({
			defaultDate: "+4w",
			changeMonth: true,
			numberOfMonths: 3,
			onSelect: function( selectedDate ) {
				$( "#from" ).datepicker( "option", "maxDate", selectedDate );
			}
		});
	});
	</script>
	<script type="text/javascript">
	    	$(document).ready(function() {
			    $('#tableautri').dataTable( {
			     			"bProcessing": true,
			                "oLanguage": {
					            "sLengthMenu": "Affichage de _MENU_ lignes par page",
					            "sZeroRecords": "Aucun enregistrement trouvé",
					            "sInfo": "Lignes _START_ à _END_ sur un total de _TOTAL_ lignes",
					            "sInfoEmpty": "Aucune ligne",
					            "sInfoFiltered": "(filtré depuis _MAX_ lignes)"
					        }
					        
	        	} );
			} );
	</script>
		<script type="text/javascript">
	    	$(document).ready(function() {
			    $('#tableautriproduit').dataTable( {
			     			"bProcessing": true,
			     			"bDeferRender": true,
			     			"sAjaxSource":'ajax/json_produit.php',
			                "oLanguage": {
					            "sLengthMenu": "Affichage de _MENU_ lignes par page",
					            "sZeroRecords": "Aucun enregistrement trouvé",
					            "sInfo": "Lignes _START_ à _END_ sur un total de _TOTAL_ lignes",
					            "sInfoEmpty": "Aucune ligne",
					            "sInfoFiltered": "(filtré depuis _MAX_ lignes)"
					        }
					        
	        	} );
			} );
	</script>
			<script type="text/javascript">
	    	$(document).ready(function() {
			    $('#tableautricatalogue').dataTable( {
			     			"bProcessing": true,
			     			"bDeferRender": true,
			     			"sAjaxSource":'ajax/json_catalogue.php?id_f=<?php echo isset($_GET['id_f'])? $_GET['id_f'] : null; ?>',
			                "oLanguage": {
					            "sLengthMenu": "Affichage de _MENU_ lignes par page",
					            "sZeroRecords": "Aucun enregistrement trouvé",
					            "sInfo": "Lignes _START_ à _END_ sur un total de _TOTAL_ lignes",
					            "sInfoEmpty": "Aucune ligne",
					            "sInfoFiltered": "(filtré depuis _MAX_ lignes)"
					        }
					        
	        	} );
			} );
	</script>
	
	<script type="text/javascript">
	    	$(document).ready(function() {
			    $('#tableautriclient').dataTable( {
			     			"bProcessing": true,
			     			"bDeferRender": true,
			     			"sAjaxSource":'ajax/json_client.php',
			                "oLanguage": {
					            "sLengthMenu": "Affichage de _MENU_ lignes par page",
					            "sZeroRecords": "Aucun enregistrement trouvé",
					            "sInfo": "Lignes _START_ à _END_ sur un total de _TOTAL_ lignes",
					            "sInfoEmpty": "Aucune ligne",
					            "sInfoFiltered": "(filtré depuis _MAX_ lignes)"
					        }
					        
	        	} );
			} );
	</script>

	<!-- CA PAR MOIS -->

<script type="text/javascript">

var options = {
    chart: {
        renderTo: 'container',
        defaultSeriesType: 'column'
    },
    title: {
        text: 'Chiffre d\'affaires'
    },
    xAxis: {
        categories: []
    },
    yAxis: {
        title: {
            text: 'Euros'
        }
    },
    
    legend: {
                align: 'right',
                x: -100,
                verticalAlign: 'top',
                y: 20,
                floating: true,
                backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColorSolid) || 'white',
                borderColor: '#CCC',
                borderWidth: 1,
                shadow: false
            },
            tooltip: {
                formatter: function() {
                    return '<b>'+ this.x +'</b><br/>'+
                        this.series.name +': '+ this.y +' €<br/>'+
                        'Total: '+ this.point.stackTotal +' €';
                }
            },
            plotOptions: {
                column: {
                    stacking: 'normal',
                    dataLabels: {
                        enabled: true,
                        color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
    
                        	}}},

    
    
    
    
    
    series: []
};

$.get('ajax/ca_par_mois.php', function(data) {
   
   var obj = jQuery.parseJSON(data);
   var xaxis = obj.xaxis;
   var webserie = obj.webserie;
   //alert (obj.xaxis);
   var boutiqueserie = obj.boutiqueserie;
   
   
   var items = xaxis.substr(1, xaxis.length - 3).split(",");
   $.each(items, function(itemNo, item) {
                options.xAxis.categories.push(item);
            });
            
            
            var items = webserie.substr(1, webserie.length - 3).split(",");
            var series = {
                data: []
            };
            series.name = "Web"

            $.each(items, function(itemNo, item) {
                
                    series.data.push(parseFloat(item));
                
            });
            
            options.series.push(series);
            
            
            var items = boutiqueserie.substr(1, boutiqueserie.length - 3).split(",");
            var series = {
                data: []
            };
            series.name = "Boutique"

            $.each(items, function(itemNo, item) {
                
                    series.data.push(parseFloat(item));
                
            });
            
            options.series.push(series);
    

    
   /*
 // Iterate over the lines and add categories or series
    $.each(lines, function(lineNo, line) {
        var items = line.split(',');
        
        // header line containes categories
        if (lineNo == 0) {
            $.each(items, function(itemNo, item) {
                if (itemNo > 0) options.xAxis.categories.push(item);
            });
        }
        
        // the rest of the lines contain data with their name in the first position
        else {
            var series = {
                data: []
            };
            $.each(items, function(itemNo, item) {
                if (itemNo == 0) {
                    series.name = item;
                } else {
                    series.data.push(parseFloat(item));
                }
            });
            
            options.series.push(series);
    
        }
        
    });
    
*/
    // Create the chart
    var chart = new Highcharts.Chart(options);
});


	</script>
	
	<!-- FIN CA PAR MOIS -->
	
	
	
	
	<!-- CA PAR JOURS -->
	
	
	
	
	
	<script type="text/javascript">

var options = {
    chart: {
        renderTo: 'caparjours',
        zoomType: 'x',
        defaultSeriesType: 'area'
    },
    title: {
        text: 'Chiffre d\'affaires'
    },
    xAxis: {
        categories: []
    },
    yAxis: {
        title: {
            text: 'Euros'
        }
    },
    
    legend: {
                align: 'right',
                x: -100,
                verticalAlign: 'top',
                y: 20,
                floating: true,
                backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColorSolid) || 'white',
                borderColor: '#CCC',
                borderWidth: 1,
                shadow: false
            },
            tooltip: {
                formatter: function() {
                    return '<b>'+ this.x +'</b><br/>'+
                        this.series.name +': '+ this.y +' €<br/>'+
                        'Total: '+ this.point.stackTotal +' €';
                }
            },
          plotOptions: {
                area: {
                    stacking: 'normal',
                    lineColor: '#666666',
                    lineWidth: 1,
                    marker: {
                        lineWidth: 1,
                        lineColor: '#666666'
                    }
                }
            },
          series: []
};

$.get('ajax/ca_par_jours.php', function(data) {
   
   var obj = jQuery.parseJSON(data);
   var xaxis = obj.xaxis;
   var webserie = obj.webserie;
   //alert (obj.xaxis);
   var boutiqueserie = obj.boutiqueserie;
   
   
   var items = xaxis.substr(1, xaxis.length - 3).split(",");
   $.each(items, function(itemNo, item) {
                options.xAxis.categories.push(item);
            });
            
            
            var items = webserie.substr(1, webserie.length - 3).split(",");
            var series = {
                data: []
            };
            series.name = "Web"

            $.each(items, function(itemNo, item) {
                
                    series.data.push(parseFloat(item));
                
            });
            
            options.series.push(series);
            
            
            var items = boutiqueserie.substr(1, boutiqueserie.length - 3).split(",");
            var series = {
                data: []
            };
            series.name = "Boutique"

            $.each(items, function(itemNo, item) {
                
                    series.data.push(parseFloat(item));
                
            });
            
            options.series.push(series);
    

    
   /*
 // Iterate over the lines and add categories or series
    $.each(lines, function(lineNo, line) {
        var items = line.split(',');
        
        // header line containes categories
        if (lineNo == 0) {
            $.each(items, function(itemNo, item) {
                if (itemNo > 0) options.xAxis.categories.push(item);
            });
        }
        
        // the rest of the lines contain data with their name in the first position
        else {
            var series = {
                data: []
            };
            $.each(items, function(itemNo, item) {
                if (itemNo == 0) {
                    series.name = item;
                } else {
                    series.data.push(parseFloat(item));
                }
            });
            
            options.series.push(series);
    
        }
        
    });
    
*/
    // Create the chart
    var chart = new Highcharts.Chart(options);
});


	</script>

<!-- FIN CA PAR JOURS -->
		

		


 
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Another way in - Votre espace client</title>
</head>
<body>
    <!-- <div class="container">     -->
        <div id="milieu" class="row">
           
 <div class="three columns" id="sidenav">
<?php include('sidebar.php'); ?>
 </div>