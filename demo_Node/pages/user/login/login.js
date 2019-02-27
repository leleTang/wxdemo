// pages/user/login/login.js
Page({
  re_Register: function(e) {
    wx.navigateTo({
      url: '../register/register',
    })
  },
  formSubmit: function(e) {
    //当点击了'submit'按钮后发出新的请求
    wx.request({
      url: 'http://18.223.126.190/wx.demo/public/api/login',
      data: {
        'token': getApp().globalData.userInfo.dev_token,
        'username': e.detail.value.username,
        'password': e.detail.value.password,
      },
      method: 'POST',
      header: {
        'content-type': 'application/x-www-form-urlencoded'
      },
      success: function(res) {
        if (res.data.status == 1) {
          //存入缓存中
          wx.setStorage({
            key: 'username',
            data: JSON.parse(res.data.data).username,
          })
          wx.setStorage({
            key: 'usertoken',
            data: JSON.parse(res.data.data).usertoken,
          })
          wx.redirectTo({
            url: '../../diary/home/home',
          })
        }else{
          wx.showToast({
            title: res.data.message,
            icon:'loading',
            duration:2000
          })
        }
      }
    })
  },
  data:{}
})