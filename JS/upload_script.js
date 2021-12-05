function plusClick(){
  compteurFichier++;
  vraiCompDeFichiers++;

  document.querySelector("#compteur").textContent=vraiCompDeFichiers;

  // creation de la ligne
  var line=document.createElement('div');
  line.setAttribute('class', 'line');

  // creation de l'input
  var input=document.createElement("input");
  input.type='file';
  input.setAttribute("name", "file"+compteurFichier);
  
  //creation du label
  var label=document.createElement("label");
  label.textContent="Nom du fichier";

  var labelta=document.createElement("label");
  labelta.textContent="Resumé";
  labelta.setAttribute("class", "f-line");

  var textarea=document.createElement("textarea");
  textarea.setAttribute("name", "fichier"+compteurFichier+"[resume]");
  var titredoc=document.createElement("label");
  titredoc.textContent="Titre du document";
  titredoc.setAttribute("class", "f-line");
  var inputtitle=document.createElement("input");
  inputtitle.setAttribute("type", "text");
  inputtitle.setAttribute("value", "titre du document");
  inputtitle.setAttribute("name", "fichier"+compteurFichier+"[titre]");

  //creation du boutton moin
  minus= document.createElement('button');
  minus.setAttribute("class", "fas fa-minus minus");
  minus.setAttribute("type", "button");
  minus.addEventListener("click", function(e){
    this.parentNode.remove();
    vraiCompDeFichiers--;
    document.querySelector("#compteur").textContent=vraiCompDeFichiers;
  })

  var uploadButton=document.querySelector("#plus");
  line.appendChild(titredoc);
  line.appendChild(inputtitle);
  line.appendChild(labelta);
  line.appendChild(textarea);
  line.appendChild(label);
  line.appendChild(input);
  line.appendChild(uploadButton);
  line.setAttribute("id", "line"+compteurFichier);
  var form=document.querySelector("form");
  
  
  var submitButton=document.querySelector("#submit_button");
  var previousline=document.querySelector("#line"+(compteurFichier-1));
  
  previousline.appendChild(minus);
  form.appendChild(line);

  form.appendChild(submitButton);
};

var compteurFichier=1;
var vraiCompDeFichiers=1;
var uploadButton=document.querySelector("#plus");
uploadButton.addEventListener("click", plusClick);

