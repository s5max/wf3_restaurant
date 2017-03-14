<?php
$title = 'La fouchette';
$css = 'assets/css/homepagecss.css';

	//inclure le header
require_once 'inc/header.php';	
 
$selectOne = $bdd->prepare('SELECT * FROM recipes LIMIT 3'); // ou DSC pour descendant et ASC ascendant

if($selectOne->execute()){
		$article = $selectOne->fetchAll(PDO::FETCH_ASSOC);
	}
	else {
		// Erreur de développement
		var_dump($selectOne->errorInfo());
		die; //Arrêter le script
	}

?>


<section id="content">
<div class="container-full">
				<div class="row">
					<!--  
					 // Les col-sm-push-* et col-sm-pull-* permettent de réordonner les colonnes 
					 // http://getbootstrap.com/css/#grid-column-ordering
					-->
					<div class="col-sm-12  ">

						<img src="assets/img/<?php echo $options['cover2'] ;?>" alt="Restaurant 1" class="full">

						<!-- Le slider/carousel de bootstrap -->
						<!--<div id="Restaurant" class="carousel slide" data-ride="carousel">
							<ol class="carousel-indicators">
								<li data-target="#Restaurant" data-slide-to="0" class="active"></li>
								<li data-target="#Restaurant" data-slide-to="1"></li>
								<li data-target="#Restaurant" data-slide-to="2"></li>
								<li data-target="#Restaurant" data-slide-to="3"></li>
								<li data-target="#Restaurant" data-slide-to="4"></li>
							</ol>

							<div class="carousel-inner container-full" role="listbox" >
								<div class="item ">
									<img src="assets/img/<?php echo $options['cover1'] ;?>" alt="Restaurant 1" class="container-full">
										<div class="carousel-caption">
										    <h3>salle 1</h3>
									    </div>
										
									
								</div>
								<div class="item active">
									<img src="assets/img/<?php echo $options['cover2'] ;?>" alt="Restaurant 2">
										<div class="carousel-caption">
										    <h3>salle 2</h3>
									    </div>
										
									
								</div>
								<div class="item">
									<img src="assets/img/<?php echo $options['cover3'] ;?>" alt="Restaurant 3">
										<div class="carousel-caption">
										    <h3>salle 3</h3>
									    </div>
									
								</div>
								<div class="item">
									<img src="<?php// echo $option['cover4'] ;?>" alt="Restaurant 4">
									    <div class="carousel-caption">
									    	<h3>salle 4</h3>
									    </div>
										
								
								</div>
								<div class="item">
									<img src="<?php// echo $option['cover5'] ;?>" alt="Restaurant 5">
								    	<div class="carousel-caption">
										    <h3>salle 5</h3>
									    </div>
									
								</div>
							</div>

							<a href="#Restaurant" class="left carousel-control" role="button" data-slide="prev">
								<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
								<span class="sr-only">Précédent</span>
							</a>
							<a href="#Restaurant" class="right carousel-control" role="button" data-slide="next">
								<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
								<span class="sr-only">Suivant</span>
							</a>
						</div>
					</div>-->

					
				</div>
			</div>
		</section>

<h1>Les recettes du chef</h1>
            <section class="gallerie">
                <div class=" container">
                    <div class="col-sm-12  col-xs-12">
                   
                        <div class="row" id="galrecette">
                          
                           <?php foreach($article as $value): ?>
                          
                                <div class="col-xs-4">
                                    <a href="view_recipe.php?id=<?php echo $value['id']?>" class="thumbnail" data-gallery="gallery">
                                        <img src="uploads/<?php echo $value['picture'];?>" alt="image 1" />
                                        <a href="view_recipe.php?id=<?php echo $value['id']?>" class="text">Lire la recette</a>
                                    </a>
                                </div>
                                
                            <?php endforeach;?>
                          
                        </div>
                    </div>                
                </div>    
           

           
                <div class="decouverte">
                    <div class="col-sm-12  col-xs-12">
                       <a href class="btn btn-primary">Découvrir toutes les recettes</a>
                       
                    </div>
                </div>
            </section>    
<?php

	//inclure le footer 
	require_once 'inc/footer.php';
?>



 
</body>
</html>