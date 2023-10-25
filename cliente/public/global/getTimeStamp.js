
const dateFormat = new Date(Date.now());
const unicDate = dateFormat.getDate() <= 9 ? '0' + dateFormat.getDate() : dateFormat.getDate();
const unicMonth = (dateFormat.getMonth() + 1) <= 9 ? '0' + (dateFormat.getMonth() + 1) : (dateFormat.getMonth() + 1);


function formatSimple(date) {
    let hours = date.getHours();
    let minutes = date.getMinutes();
    let seconds = date.getSeconds();
    // var ampm = hours >= 12 ? 'pm' : 'am';
    hours = hours % 12;
    hours = hours ? hours : 12; // the hour '0' should be '12'
    return `${hours <= 9 ? '0' + hours: hours}:${minutes <= 9 ? '0' + minutes: minutes}:${seconds <= 9 ? '0' + seconds: seconds}+00`;
}


const finalDate = `${dateFormat.getFullYear()}-${unicMonth}-${unicDate} ${formatSimple(new Date)}`;
