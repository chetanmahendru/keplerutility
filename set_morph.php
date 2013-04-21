<html>
  <head>
  
  <title>Phoenix Kepler-Planet Explorer</title>
  <script>
  function pass(obj){
    document.getElementById('kid').value = obj.value;
  }
  </script>
  </head>
  <body>
  <div style="float:top;backgroud-color:'grey';" >
    <center><h3>Phoenix Kepler-Planet Explorer</h3><center>
  </div>
    
    <?php
    
      $kid = $_POST['kid'];
      $db  = new PDO('sqlite:kepler_data_sql.db') or die("cannot open the database");
      
      $qry = 'select * from kdata where kic='.$kid;
      $result=$db->query($qry);
      $row=$result->fetch(SQLITE_ASSOC);
      echo '<input type=hidden id=morph value='.$row['morph'].'>';
      echo '<input type=hidden id=kid_value value='.$row['kic'].'>';
      echo '<input type=hidden id=bjd_value value='.$row['bjd'].'>';
      echo '<input type=hidden id=period_value value='.$row['period'].'>';
    ?>
    <br><br>
    <form method="post" action="get_morph_php.php">
    <input name="kid" id="kid">
    <input type=submit value="Get Planet!!" >  
    </form>  
    <br>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<div style="float:left; width:120px;">
  <select size=30 style="width:100px; float:center;">
  <?php
  
    $db  = new PDO('sqlite:kepler_data_sql.db') or die("cannot open the database");
      
      $qry = 'select * from kdata where rowid<31';
      $result=$db->query($qry);
     
      while($row=$result->fetch(SQLITE_ASSOC)){
          
          echo "<option onClick=pass(this)>".$row['kic']."</option>" ;
    }
  ?>
  </select>
  </div>
    <br><div id="canvas_wrapper"></div>
    </div>
    <div id="details">
    
    </div>
    <script src="three.min.js"></script>

  <script>
  
    var period_temp = document.getElementById('period_value').value;
    
    var camera, scene, renderer;
  	var geometry, material, mesh;
    
    var textures = new Array(
      "textureImages/mercurymap.jpg",
      "textureImages/venusmapthumb.jpg",
      "textureImages/venusmapthumb.jpg",
      "textureImages/jupiter2_1k.jpg",
      "textureImages/mercurybump.jpg",
      "textureImages/venusbump.jpg",
      "textureImages/mars_topo_thumbnail.jpg",
      "textureImages/plutomap2k.jpg"
    );
   
    var texture_image = "mercurymap.jpg";
    var morph = document.getElementById('morph').value;
     
    
  	if(period_temp<20)
  	   texture_image = textures[0];
    else if(period_temp<30)
  	   texture_image = textures[1];
  	else if(period_temp<40)
  	   texture_image = textures[2];
    else if(period_temp<70)
  	   texture_image = textures[3];
    else if(period_temp<90)
  	   texture_image = textures[4];
    else if(period_temp<100)
  	   texture_image = textures[5];
    else if(period_temp<700)
  	   texture_image = textures[6];
    else
  	   texture_image = textures[7];                  
    
  
    init();
  	animate();
  
  	function init() {
  
  		camera = new THREE.PerspectiveCamera( 75, window.innerWidth / window.innerHeight, 1, 2000 );
  		camera.position.z = 1000;
  
  		scene = new THREE.Scene();
  
  		geometry = new THREE.SphereGeometry( 450, 25, 25 );
  		
  		material = new THREE.MeshLambertMaterial({
          map: THREE.ImageUtils.loadTexture(texture_image), anisotropy:true
        });
  
  		mesh = new THREE.Mesh( geometry, material );
  		mesh.scale.y = morph;
      
      
      scene.add( mesh );
  
      renderer = new THREE.CanvasRenderer();
  		
      renderer.setSize(window.innerWidth/2, window.innerHeight/2);
  		
      document.getElementById('canvas_wrapper').appendChild( renderer.domElement );
  
  	}
  
  	function animate() {
  
  		// note: three.js includes requestAnimationFrame shim
  		requestAnimationFrame( animate );
  
  		mesh.rotation.y += 0.01;
  
  		renderer.render( scene, camera );
  
  	}
    
    /*
    var light = new THREE.PointLight( 0xB04A06);
      
    light.position.set( 800, 0, 0 );
      
    scene.add( light );
    */
    
    var kic_temp = document.getElementById('kid_value').value;
    var period_temp = document.getElementById('period_value').value;
    var bjd_temp = document.getElementById('bjd_value').value;
    var morph_temp = document.getElementById('morph').value;
    
    document.getElementById('details').innerHTML += "Keppler ID : "+kic_temp+"<br>Period : "+period_temp+"<br>BJD : "+bjd_temp+"<br>Morph Value : "+morph_temp;
  </script>
  </body>
</html>
