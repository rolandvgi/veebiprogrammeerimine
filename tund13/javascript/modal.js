let modal;
let modalImg;
let captionText;
let closeBtn;
let photoDir = "../vp_pic_uploads/";
let modalId;

window.onload = function(){
	modal = document.getElementById("myModal");
	modalImg = document.getElementById("modalImg");
	captionText = document.getElementById("caption");
	closeBtn = document.getElementsByClassName("close")[0];
	let allThumbs = document.getElementById("gallery").getElementsByTagName("img");
	let thumbCount = allThumbs.length;
	for(let i = 0; i < thumbCount; i++){
		allThumbs[i].addEventListener("click", openModal);
	}
	closeBtn.addEventListener("click", closeModal);
	modalImg.addEventListener("click", closeModal);
	document.getElementById("storeRating").addEventListener("click", storeRating);
}

function openModal(e){
	modal.style.display = "block";
	modalImg.src = photoDir + e.target.dataset.fn;
	modalId = e.target.dataset.id;
	captionText.innerHTML = e.target.alt;
	for(let i = 1; i < 6; i ++){
		document.getElementById("rate"+i).checked = false;
	}
	
}

function storeRating(){
	let rating = 0;
	for(let i = 1; i < 6; i ++){
		if(document.getElementById("rate"+i).checked){
			rating = i;
		}
	}
	if(rating>0){
		//AJAX loome veebipäringu, määrame,mis juhtub kui see edukalt tehtud saab ja saadud vastust kasutame lehel javascripti abil sisu muutmiseks
		let request = new XMLHttpRequest();
		request.onreadystatechange = function(){
			if(this.readyState == 4 && this.status ==200){
				document.getElementById("avgRating").innerHTML = this.responseText;
				document.getElementById("score" + modalId).innerHTML = this.responseText;

			}
		}
		//siin määrate veebiaadressi ja parameetrid
		//savephotorating.php?id=7&rating=4
		request.open("GET", "savephotorating.php?id=" + modalId + "&rating=" + rating, true);
		request.send();
		//AJAX lõppeb
	}
}

function closeModal(){
	modal.style.display = "none";
}