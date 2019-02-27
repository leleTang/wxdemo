//index.js
//获取应用实例
var app = getApp()
Page({
  data: {
     items: [
      {name: '1', value: '选择1'},
      {name: '2', value: '选择2'},
      {name: '3', value: '选择3'},
    ],
    disabled:true,
    checked:true,
  },
  //事件处理函数
  bindViewTap: function() {
    wx.navigateTo({
      url: '../logs/logs'
    })
  },
  onLoad: function () {
    console.log('onLoad')
    var that = this
    //调用应用实例的方法获取全局数据
    app.getUserInfo(function(userInfo){
      //更新数据
      that.setData({
        userInfo:userInfo
      })
    })
  }
})
