document.querySelector(".number").onkeyup = inValidate;
var inputs = document.getElementsByName("coordX");
for(var i = 0; i < inputs.length; i++) inputs[i].onchange = checkboxHandler;
document.getElementById("send").onclick = function(){
    sendReq();
};

function checkboxHandler(e) {
    for(var i = 0; i < inputs.length; i++)
        if(inputs[i].checked && inputs[i] !== this) inputs[i].checked = false;
}

function inValidate() {
    this.value = this.value.replace(/[^\d\-\,]/, "");
    if(this.value.lastIndexOf("-")> 0) {
        this.value = this.value.substr(0, this.value.lastIndexOf("-"));
    }
    if(this.value[0]== "-") {
        if(this.value.match(/^-[,3-9]/)){
            this.value = this.value.substr(0, 1);
        }
        if(this.value.length>2 && this.value[2]!=",") this.value=this.value[0]+this.value[1]+","+this.value[2];
        if(this.value.length>8) this.value = this.value.substr(0, 8);
    }else{
        if(this.value.match(/^[,3-9]/)){
            this.value = this.value.substr(0, 0);
        }

        if(this.value.length>1 && this.value[1]!=",") this.value=this.value[0]+","+this.value[1];
        if(this.value.length>7) this.value = this.value.substr(0, 7);
    }

    if(this.value.match(/\,/g).length > 1) {
        this.value = this.value.substr(0, this.value.lastIndexOf(","));
    }
}

function sendReq() {
    let x = document.querySelector("input[type=checkbox]:checked").value;
    let y = document.querySelector(".number").value;
    let r = document.querySelector("input[type=radio]:checked").value;
    fetch("./php/script.php", {
        method: "POST",
        headers: {'Content-Type': 'application/x-www-form-urlencoded;charset=utg-8'},
        body: "x=" + encodeURIComponent(x) + "&y=" + encodeURIComponent(y.replace(",",".")) + "&r=" + encodeURIComponent(r) +
            "&timezone=" + encodeURIComponent(Intl.DateTimeFormat().resolvedOptions().timeZone)
    }).then(response => response.text()).then(function (serverAnswer) {
        document.getElementById("outputContainer").innerHTML = serverAnswer;
    })
}