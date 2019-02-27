//index.js
//获取应用实例
var app = getApp()
var i=0
Page({
  bindGetFocus: function() {
    console.log("Get Focus")
  },
  bindLostFocus: function(e) {
    console.log("Lost Focus")
  },
  bindLineChanged:function(e){    
    i=i+1
    console.log("这是第"+i+"行")
  }
})
