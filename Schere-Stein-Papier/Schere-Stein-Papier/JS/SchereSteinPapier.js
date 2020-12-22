"use strict!"
//Schere 1 | Stein 2 | Papier 3
let table = new Array();
table[0] = new Array ("0","2","1"); //Schere
table[1] = new Array ("1","0","2"); // Stein
table[2] = new Array ("2","1","0"); // Papier
let user;
let zaehler;
let comp;
let counter = 1;
let ppuser = 0;
let ppc = 0;
let erg;
let res;
let gewinner;
let fin;
let namen;
let games;

namen = prompt("Bitte Namen eingeben: ");
if(namen == undefined){
    namen = "SPIELER"
}
games = prompt("Wieviele Runden sollen gespielt werden? (Max 9 Runden)")
if(games < 1 || games > 9 ){
    prompt("Die Zahl muss zwischen 1 und 9 liegen")
}
console.log(namen);
document.getElementById('spu').innerHTML = namen.toLocaleUpperCase();
user = document.addEventListener(onclick,Benutzer);
console.log("Runde" + counter);
document.getElementById('turn').innerHTML = counter;

fin = document.addEventListener(onclick,ende);   
// Computer wählt ein Symbol => speichern
function Pc(wert){
    comp =Math.round(Math.random()*2); 
    console.log("Der Computer" + comp);
    
}
//comp = document.addEventListener(onclick,Pc);

// User Symbol Speichern
function Benutzer(wert){
    let text;
    let aus;
    Pc(wert);
    
    user = wert.value;
    erg = table[comp][user];
    console.log("Ergebnis " + erg) + "PC " + comp + "User " + user;
    if (erg == 0){
        res = "Unentschieden";
        text = "PC: " + zuwpc(comp) + " - " + namen.toLocaleUpperCase()+":" + " " + zuwuser(user) + "<br>" + res; 
        document.getElementById('rest').innerHTML =text + "<br>";
        ppc += 0;
        ppuser += 0;
        document.getElementById('pkc').innerHTML = ppc;
        console.log(ppc);
        document.getElementById('pku').innerHTML = ppuser;
        console.log(ppuser);
        
    }
    else if(erg == 1){
        res = "PC hat gewonnen";
        text = "PC: " + zuwpc(comp) + " - " + namen.toLocaleUpperCase()+":" + " " + zuwuser(user) + "<br>" + res;
        document.getElementById('rest').innerHTML = text + "<br>";
        ppc +=1;
        document.getElementById('pkc').innerHTML = ppc;
        console.log(ppc);
        ppuser +=0;
        document.getElementById('pku').innerHTML = ppuser;
        console.log(ppuser);
        
    }
    else if(erg == 2){
        res = namen.toLocaleUpperCase() + " hat gewonnen";
        text = "PC: " + zuwpc(comp) + " - " + namen.toLocaleUpperCase()+":" + " " + zuwuser(user) + "<br>" + res;
        document.getElementById('rest').innerHTML= text + "<br>";
        ppuser +=1;
        document.getElementById('pku').innerHTML = ppuser;
        console.log(ppuser);
        ppc +=0;
        document.getElementById('pkc').innerHTML = ppc;
        console.log(ppc);     
    }
    setTimeout(count,2000);
}
function ende(){
    location.reload();
}

function count() {
      
     
    if (counter == games){
        // gewinner ermitteln
        if (ppc > ppuser){
            alert("LEIDER VERLOREN!!!");
            ende();  
        }
        else if (ppuser > ppc){
            alert("GEWONNEN!!!!");
            ende();      
        }
        else{
            alert("unentschieden");
            ende(); 
        }
    }
    counter +=1;
    document.getElementById('turn').innerHTML = counter; 
}
function zuwuser(user){
    let us;
    if (user == 0){
        us = "Schere"
    }
    else if (user == 1){
        us = "Stein"
    }
    else if (user ==2){
        us = "Papier"
    }
    return us;
}
function zuwpc(comp){
    let pc;
    if (comp == 0){
        pc = "Schere"
    }
    else if (comp == 1){
        pc = "Stein"
    }
    else if (comp = 2){
        pc = "Papier"
    }
    return pc;
}



    
    





// User Symbol und Comp Symbol vergleichen
// Array durchlaufen 
// Wenn Array 0 Unterschieden ausgeben 
// Wenn Array 1 Sieger User ausgeben
//Wenn Array 2 Sieger Comp ausgebe