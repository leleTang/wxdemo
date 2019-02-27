// pages/user/index/index.js
Page({
  data:{},
  onLoad:function(options){
    // wx.redirectTo({
    //   url: '../../diary/home/home',
    // })
    wx.request({
      url: 'http://18.223.126.190/wx.demo/public/api/login',
      data:{
        'token': getApp().globalData.userInfo.dev_token,
        'usertoken':wx.getStorageSync('usertoken')
      },
      method:'POST',
      header:{
        'content-type': 'application/x-www-urlencoded'
      },
      success:function(res){
        if(res.data.status==1){
          wx.redirectTo({
            url: '../../diary/home/home',
          })
        }else{
         wx.showToast({
           title: 'res.data.message',
           icon:'loading',
           duration:1000,
           success:function(res){
             wx.redirectTo({
               url: '../login/login',
             })
           }
         })
        }
      }
    })
  }
})