function scodehtml(id, name) {
return '<div class="form-group" style="width: 100px;">'+
'<label class="tn">filter</label>'+
'<select id="s'+id+'" name="si[]" class="form-control dpl" onchange="mof(this)">'+
    '<option value="none">none</option>'+
    '<option value="=">equals</option>'+
    '<option value="!=">not equals</option>'+
    '<option value=">">greater</option>'+
    '<option value=">=">greater equals</option>'+
    '<option value="<">less</option>'+
    '<option value="<=">less equal</option>'+
    '<option value="contain">contains</option>'+
    '<option value="not contain">not contains</option>'+
'</select>'+
'<input type="text" id="i'+id+'" name="in[]" onkeyup="myf(this)" class="form-control dpl" disabled>'+
'<input type="hidden" name="hcn[]" value="'+name+'">'+
'</div>'
}

let objfilter = {};
let funfilter = {};
let resrow = [];
let limitrow = 15;
let curpage = 1;

$(document).ready(function() {
    let node = $('.clscol');
    let len = node.length;
    for (let i = 1; i <= len; i++){
        $(node[i-1]).html(scodehtml(i, colname[i-1]));
        objfilter["i"+i] = [];
        switch(coltype[i-1]) {
            case "string":
                funfilter["i"+i] = funstr;
            break;
            case "integer":
                funfilter["i"+i] = funint;
            break;
            case "datetime":
                funfilter["i"+i] = fundte;
            break;
        }
    }
    let tr = document.getElementsByClassName("trw");
    len = tr.length;
    for (let i = 0; i < len; i++){
        resrow[i] = false;
    }
    paging();
});

function mof(self) {
    if (($(self).prop("value")) == "none") {
        $(self.nextElementSibling).prop("disabled", true);
        $(self.nextElementSibling).prop("value", "");
    }else{$(self.nextElementSibling).prop("disabled", false)}
    myf(self.nextElementSibling);
}

function myf(self) {
    let id, filter, method, tr, td, i, txtValue;
    id = self.id;
    filter = self.value.toUpperCase();
    tr = document.getElementsByClassName("trw");
    method = self.previousElementSibling.value;
    objfilter[id] = [];
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByClassName("c"+id)[0];
        tr[i].style.display = "";
        resrow[i] = false;
        if (filter != ""){
            if (td) {
                txtValue = td.textContent || td.innerText;
                objfilter[id].push(funfilter[id](method, txtValue.toUpperCase(), filter));
            }
        }
    }
    filting();
}

function cpage(self) {
    curpage = parseInt(self.textContent, 10);
    tr = document.getElementsByClassName("trw");
    for (i = 0; i < tr.length; i++) {
        tr[i].style.display = "";
    }
    filting();
}

function filting(){
    let tr = document.getElementsByClassName("trw");
    let len = tr.length;
    let vis;
    for(vis in objfilter){
        let ilen = objfilter[vis].length;
        if (ilen > 0) {
            console.log(objfilter[vis])
            for (let i = 0; i < len; i++) {
                if (!resrow[i]) {
                    if (objfilter[vis][i]) {
                        resrow[i] = true;
                    }
                }
            }
        }
    }
    console.log(resrow);
    paging();
}

function paging() {
    let tr = document.getElementsByClassName("trw");
    let len = tr.length;
    let n = 1, r = 0, level = 1, h = 0;
    for (let i = 0; i < len; i++) {
        if (!resrow[i]) {
            if (level != curpage) {
                tr[i].style.display = "none";
            }else{
                tr[i].getElementsByClassName("cn")[0].textContent = n+(limitrow*(level-1));
                tr[i].style.display = "";
                h++;
            }
            if (n >= limitrow) {
                n = 0;
                level++;
            }
            n++;
        }else{
            tr[i].style.display = "none";
            r++;
        }
    }
    r = len-r;

    let tbpage = document.getElementById("tbpage");
    $(tbpage).empty();
    for (let i = 1; i <= level; i++) {
        let btn = document.createElement("BUTTON");
        btn.setAttribute("type", "button");
        btn.setAttribute("class","btn btn-white border border-secondary");
        btn.setAttribute("onclick","cpage(this)");
        btn.textContent = i;
        if (i == curpage){
            btn.disabled = true;
            tbpage.append(btn);
        }else{
            tbpage.append(btn);
        }
    }
    $('.tbshow').html('Menampilkan '+h+' dari '+r);
}

function funstr(met, val, fil) {
    switch(met) {
        case "contain":
            if (!(val.indexOf(fil) > -1)) {
                return true;
            }else{
                return false;
            }
        case "not contain":
            if (!(val.indexOf(fil) <= -1)) {
                return true;
            }else{
                return false;
            }
        case "=":
            if (!(val == fil)) {
                return true;
            }else{
                return false;
            }
        case "!=":
            if (!(val != fil)) {
                return true;
            }else{
                return false;
            }
        case ">":
            if (!(val.localeCompare(fil) > 0)) {
                return true;
            }else{
                return false;
            }
        case ">=":
            if (!(val.localeCompare(fil) >= 0)) {
                return true;
            }else{
                return false;
            }
        case "<":
            if (!(val.localeCompare(fil) < 0)) {
                return true;
            }else{
                return false;
            }
        case "<=":
            if (!(val.localeCompare(fil) <= 0)) {
                return true;
            }else{
                return false;
            }
    }
}
function funint(met, ival, ifil) {
    let val = parseInt(ival, 10);
    let fil = parseInt(ifil, 10);
    switch(met) {
        case "contain":
            if (!(ival.indexOf(ifil) > -1)) {
                return true;
            }else{
                return false;
            }
        case "not contain":
            if (!(ival.indexOf(ifil) <= -1)) {
                return true;
            }else{
                return false;
            }
        case "=":
            if (!(val == fil)) {
                return true;
            }else{
                return false;
            }
        case "!=":
            if (!(val != fil)) {
                return true;
            }else{
                return false;
            }
        case ">":
            if (!(val > fil)) {
                return true;
            }else{
                return false;
            }
        case ">=":
            if (!(val >= fil)) {
                return true;
            }else{
                return false;
            }
        case "<":
            if (!(val < fil)) {
                return true;
            }else{
                return false;
            }
        case "<=":
            if (!(val <= fil)) {
                return true;
            }else{
                return false;
            }
    }
}
function fundte(met, ival, ifil) {
    let val = parseInt(ival.slice(0,4)+ival.slice(5,7)+ival.slice(8,10), 10);
    let result = funint(met, val, ifil);
    return result;
}