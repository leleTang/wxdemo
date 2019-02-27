// pages/diary/add/add.js
Page({
  data: {},
  onLoad: function(options) {
    this.setData({
      date: new Date().getFullYear() + "-" + (new Date().getMonth() + 1) + "-" + new Date().getDate()
    })
  },
  bindDateChange: function(e) {
    this.setData({
      date: e.detail.value
    })
  },
  formSubmit: function(e) {
    var temp;
    if (e.detail.value.status) {
      temp = 1;
    } else {
      temp = 0;
    }
    //页面初始化后发出新的请求
    wx.request({
      url: 'http://18.223.126.190/wx.demo/public/api/write',
      data: {
        'token': getApp().globalData.userInfo.dev_token,
        'usertoken': wx.getStorageSync('usertoken'),
        'title': e.detail.value.title,
        'date': Math.round(new Date(e.detail.value.date).getTime() / 1000),
        'text': e.detail.value.text,
        'status': temp
      },
      method: 'POST',
      header: {
        'content-type': 'application/x-www-form-urlencoded'
      },
      success: function(res) {
        if (res.data.status == 1) {
          wx.redirectTo({
            url: '../home/home',
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