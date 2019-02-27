// pages/user/register/register.js
Page({
  data:{},
  formSubmit:function(e){
    //对于是否两次密码输入一致进行判断
    if (e.detail.value.password == e.detail.value.re_password) {
      //当单机了submit按钮后发出新的请求
      wx.request({
        url: 'http://18.223.126.190/wx.demo/public/api/register',
        data:{
          'token':getApp().globalData.userInfo.dev_token,
          'username':e.detail.value.username,
          'password': e.detail.value.password
        },
        method:'POST',
        header:{
          'content-type':'application/x-www-form-urlencoded'
        },
        success:function (res){
          console.log(res.data)
          if(res.data.status==1){
            //存入缓存中
            wx.setStorage({
              key: 'username',
              data: JSON.parse(res.data.data).username,
            })
            wx.setStorage({
              key: 'usertoken',
              data: JSON.parse(res.data.data).usertoken,
            })
            wx.showToast({
              title: res.data.message+",请返回登录~",
              icon:"success",
              duration:2000
            })
          }else{
            wx.showToast({
              title: res.data.message,
              icon:"loading",
              duration:2000
            })
          }
        }
      })
    }else{
      wx.showToast({
        title: '两次输入密码不一致,请检查',
        icon:'loading',
        duration:2000
      })
    }
  }
})