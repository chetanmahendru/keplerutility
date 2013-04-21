<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
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
  <div style="float:top;backgroud-color:grey" >
    <center><h3>Phoenix Kepler-Planet Explorer</h3><center>
  </div>
  <br><br>
  
  <form method="post" action="get_morph_php.php">
    <input name="kid" id="kid">
    <input type=submit value="Get Planet!!" >    
  </form>
  <br>
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  <div style="float:left; width:120px;">
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
  <div id='canvas_wrapper'></div>
  <div id="details" style="float:right;"></div>
  <script src="three.min.js"></script>

  <script>
  
    var camera, scene, renderer;
  	var geometry, material, mesh;
    
    var texture_image = "textureImages/jupiter2_1k.jpg";
    var morph = 0.90;
      
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
  </script>
  </body>
</html>
