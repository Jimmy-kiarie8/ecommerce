<script type="text/javascript">
var imagecount=1;
var total=5;
function slide(x) {
	// body...
  var image= document.getElementById('img');
  imagecount=imagecount+x;
  image.src="img/img"+imagecount+".jpg";
  if (imagecount>total) {
  	imagecount=1;
  }
  if (imagecount<x) {
  	imagecount=total;
  }
}

window.setInterval(
	function slideA() {
	// body...
  var image= document.getElementById('img');
  imagecount=imagecount+1;
  image.src="img/img"+imagecount+".jpg";
  if (imagecount>total) {
  	imagecount=1;
  }
  if (imagecount<1) {
  	imagecount=total;
  }
}, 1000);

</script>