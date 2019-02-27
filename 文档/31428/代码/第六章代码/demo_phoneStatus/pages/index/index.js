//index.js
//获取应用实例
var app = getApp()
var networkType
Page({
  data: {
    phonedata: {},
    line: {}
  },
  //事件处理函数
  bindViewTap: function () {
    wx.navigateTo({
      url: '../logs/logs'
    })
  },
  onLoad: function () {    
    wx.getNetworkType({
      success: function (res) {
        // 返回网络类型, 有效值：
        // wifi/2g/3g/4g/unknown(Android下不常见的网络类型)/none(无网络)
        networkType = res.networkType
      }
    })
    this.setData({
      phonedata: wx.getSystemInfoSync(),
      line: networkType
    }
    )
    console.log(this.data.phonedata)
  },
  onReady:function(){
        this.setData({
      line: networkType
    }
    )
  }
})
