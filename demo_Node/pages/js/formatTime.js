//数据转化
function formatNumber(n) {
  n = n.toString()
  return n[1] ? n : '0' + n
}
//转换星期
function week(dd) {
  var str = "";
  if (dd == 0) {
    str = "星期日";
  } else if (dd == 1) {
    str = "星期一";
  } else if (dd == 2) {
    str = "星期二";
  } else if (dd == 3) {
    str = "星期三";
  } else if (dd == 4) {
    str = "星期四";
  } else if (dd == 5) {
    str = "星期五";
  } else if (dd == 6) {
    str = "星期六";
  }
  return str;
}
/**
 * 时间戳转化为年 月 日 时 分 秒
 * number: 传入时间戳
 * format：返回格式，支持自定义，但参数必须与formateArr里保持一致
*/
function formatTime(number, format) {

  var formateArr = ['Y', 'M', 'D', 'dd', 'h', 'm', 's'];
  var returnArr = [];

  var date = new Date(number * 1000);
  returnArr.push(date.getFullYear());
  returnArr.push(formatNumber(date.getMonth() + 1));
  returnArr.push(formatNumber(date.getDate()));
  returnArr.push(week(date.getDay()))
  returnArr.push(formatNumber(date.getHours()));
  returnArr.push(formatNumber(date.getMinutes()));
  returnArr.push(formatNumber(date.getSeconds()));

  for (var i in returnArr) {
    format = format.replace(formateArr[i], returnArr[i]);
  }
  return format;
}
module.exports = {
  formatTime: formatTime,
  week: week,
  formatNumber: formatNumber
}