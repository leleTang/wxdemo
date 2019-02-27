// pages/diary/diary/diary.js
var formatTime = require('../../js/formatTime.js');  
var temp_data;
var option;
Page({
  data: {
    article: {}
  },
  onLoad: function (options) {
    //页面初始化options为页面跳转所带来的参数
    option = options
  },
  onReady: function() {
    var page = this;
    wx.request({
      url: 'http://18.223.126.190/wx.demo/public/api/pread',
      data: {
        'token': getApp().globalData.userInfo.dev_token,
        'usertoken': wx.getStorageSync('usertoken'),
        'articleid': option.id
      },
      method: 'POST',
      header: {
        'content-type': 'application/x-www-form-urlencoded'
      },
      success: function(res) {
        if (res.data.status == 1) {
          temp_data = JSON.parse(res.data.data);
          for (var i = 0; i < temp_data.length; i++) {
            temp_data[i].date = formatTime.formatTime(temp_data[i].date, 'Y年M月D日');
          }
          page.setData({
            article: temp_data[0]
          })
        } else {
          wx.showToast({
            title: res.data.message,
            icon: 'loading',
            duration: 2000
          })
        }
      }
    })
  }
})