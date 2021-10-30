function checkValidates() {
    var fName = document.forms["RegForm"]["first-name"];
    var lName = document.forms["RegForm"]["last-name"];
    var studNumb = document.forms["RegForm"]["student-number"];
    var yearLvl = document.forms["RegForm"]["year-level"];
    var email = document.forms["RegForm"]["email"];
    var program = document.forms["RegForm"]["program"];
    var birthDate = document.forms["RegForm"]["birth-date"];
    var sex = document.forms["RegForm"]["sex"];
    
    alert(studNumb.type);

    return false;
}