let prevVal;
let prevX, prevY;

function edit(x, y){
    if(x==0 || x==prevX || y==prevY){
        return;
    }
    if(prevVal != null) {
        document.getElementById("cell" + prevX + "," + prevY).innerHTML = prevVal;
    }
    let cell = document.getElementById("cell"+x+","+y);
    prevVal = cell.innerHTML;
    prevX = x;
    prevY = y;
    cell.innerHTML = inputs[x-1].replace("addForm", "editForm").replace("data"+(x-1), "data"+(x-1)+","+document.getElementById("cell0,"+y).innerText);
    cell.childNodes[0].value = prevVal;
}
