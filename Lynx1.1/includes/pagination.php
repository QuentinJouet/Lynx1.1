 <ul class="pagination" style="text-align:center;">
            <?php
		//On initialise le tableau de get
		$tableau_get=array();
		$tableau_get['o']=$dec;
		$tableau_get['tri']=$tri;
		$tableau_get['p_p']=$per_page;
		$tableau_get['fltr']=$filtre;
		$tableau_get['vlr']=$valeur;
		global $page;
		//Initialisation pour nav avec keys
		$tableau_get['page']=$page;
		$nextpage=nom_page().'?'.http_build_query($tableau_get);
		$prevpage=$nextpage;
		
		//réinitialisation pour nav normale
		$tableau_get['page']=1;
		
            if($pagination->total_pages() > 1) {
                
                if($pagination->has_previous_page()) { 
		    		$tableau_get['page']=$pagination->previous_page();
				echo '<li class="arrow"><a href="';
				echo nom_page();
				echo '?';
				echo http_build_query($tableau_get);
				echo '">&laquo; Préc.</a></li>';
				$prevpage=nom_page().'?'.http_build_query($tableau_get);
            }
        
                for($i=max(1,$page-7); $i <= (min($pagination->total_pages(),$page+7)); $i++) {
                    if($i == $page) {
                        echo " <li class=\"current\"><a href=\"\">{$i}</a></li> ";
                    } else {
                        echo " <li><a href=\"";
						echo nom_page();
						$tableau_get['page']=$i;
						echo '?';
						echo http_build_query($tableau_get)	;
						echo"\">{$i}</a></li> "; 
                    }
                }
        
                if($pagination->has_next_page()) { 
				echo '<li class="arrow"><a href="';
				echo nom_page();
				echo '?';
				$tableau_get['page']= $pagination->next_page();				
				echo http_build_query($tableau_get);
				echo '">Suiv. &raquo;</a></li>';
				//Pour nav avec keys
				$nextpage=nom_page().'?'.http_build_query($tableau_get);
                    
            }
                
            }
        
        ?>
        </ul>