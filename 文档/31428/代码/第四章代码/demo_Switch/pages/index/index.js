//index.js
//获取应用实例
var app = getApp()
Page({
  switch1Change: function (e){
    console.log('点击switch1', e.detail.value)
  },
  switch2Change: function (e){
    console.log('点击switch2', e.detail.value)
  }
})
