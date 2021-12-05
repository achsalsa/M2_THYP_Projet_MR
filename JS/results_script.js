// cloud btn part
var cloud_btn=document.querySelectorAll(".cloud_btn");
var modal_ndm=document.querySelector(".modal_ndm");

for(i=0;i<cloud_btn.length;i++){
    cloud_btn[i].addEventListener("click", function(e){
       modal_ndm.classList.add("is-active");
    });
}

var ndp_close_cross=document.querySelector(".ndp_delete");
var ndp_close_btn=document.querySelector(".ndp_btn");

ndp_close_cross.addEventListener("click", function(){
    modal_ndm.classList.remove("is-active");
});
ndp_close_btn.addEventListener("click", function(){
    modal_ndm.classList.remove("is-active");
});

// stars btn part
var stars_modals=document.querySelectorAll(".stars_btn");
var modal_notes=document.querySelector(".modal_stars");

for(i=0;i<stars_modals.length;i++){
    stars_modals[i].addEventListener("click", function(e){
       modal_notes.classList.add("is-active");
    });
}

var stars_close_cross=document.querySelector(".stars_delete");
var stars_close_btn=document.querySelector(".stars_btn");

stars_close_cross.addEventListener("click", function(){
    modal_notes.classList.remove("is-active");
});
stars_close_btn.addEventListener("click", function(){
    modal_notes.classList.remove("is-active");
});
