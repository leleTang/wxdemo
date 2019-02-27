// pages/diary/home/home.js
var formatTime = require('../../js/formatTime.js');
var temp_data;
Page({
  data: {
    items: [],
    delBtnWidth: 180 //删除按钮宽度单位（rpx）
  },
  onLoad: function(e) {
    var page = this;
    //页面初始化后发出新的请求
    wx.request({
      url: 'http://18.223.126.190/wx.demo/public/api/plist',
      data: {
        'token': getApp().globalData.userInfo.dev_token,
        'usertoken': wx.getStorageSync('usertoken')
      },
      method: 'POST',
      header: {
        'content-type': 'application/x-www-form-urlencoded'
      },
      success: function (res) {
        if (res.data.status == 1) {
          temp_data = JSON.parse(res.data.data);
          for (var i = 0; i < temp_data.length; i++) {
            temp_data[i].day = formatTime.formatTime(temp_data[i].date, 'dd');
            temp_data[i].dateDay = formatTime.formatTime(temp_data[i].date, 'D');
            temp_data[i].date = formatTime.formatTime(temp_data[i].date, 'Y年M月');
            temp_data[i].txtStyle = "left: 0px";
          }
          page.setData({
            items: temp_data
          })
        } else {
          wx.showToast({
            title: res.data.message,
            icon: 'loading',
            duration: 2000
          })
        }
      }
    });
    this.initEleWidth();
  },
  onReady: function(e) {
    
  },
  touchS: function(e) {
    if (e.touches.length == 1) {
      this.setData({
        //设置触摸起始点水平方向位置
        startX: e.touches[0].clientX
      });
    }
  },
  touchM: function(e) {
    var page = this;
    if (e.touches.length == 1) {
      //手指移动时水平方向位置
      var moveX = e.touches[0].clientX;
      //手指起始点位置与移动期间的差值
      var disX = this.data.startX - moveX;
      var delBtnWidth = this.data.delBtnWidth;
      var txtStyle = "";
      if (disX == 0 || disX < 0) { //如果移动距离小于等于0，文本层位置不变
        txtStyle = "left:0px";
      } else if (disX > 0) { //移动距离大于0，文本层left值等于手指移动距离
        txtStyle = "left:-" + disX + "px";
        if (disX >= delBtnWidth) {
          //控制手指移动距离最大值为删除按钮的宽度
          txtStyle = "left:-" + delBtnWidth + "px";
        }
      }
      //获取手指触摸的是哪一项
      var index = e.currentTarget.dataset.index;
      var items = temp_data;
      if (index >= 0) {
        temp_data[index].txtStyle = txtStyle;
        //更新列表的状态
        page.setData({
          items: items
        });
      }
    }
  },

  // touchE: function(e) {
  //   var page = this;
  //   if (e.changedTouches.length == 1) {
  //     //手指移动结束后水平位置
  //     var endX = e.changedTouches[0].clientX;
  //     //触摸开始与结束，手指移动的距离
  //     var disX = this.data.startX - endX;
  //     var delBtnWidth = this.data.delBtnWidth;
  //     //如果距离小于删除按钮的1/2，不显示删除按钮
  //     var txtStyle = disX > delBtnWidth / 2 ? "left:-" + delBtnWidth + "px" : "left:0px";
  //     //获取手指触摸的是哪一项
  //     var index = e.target.dataset.index;
  //     var items = temp_data;
  //     if (index >= 0) {
  //       temp_data[index].txtStyle = txtStyle;
  //       //更新列表的状态
  //       page.setData({
  //         items: items
  //       });
  //     }
  //   }
  // },
  //获取元素自适应后的实际宽度
  getEleWidth: function(w) {
    var real = 0;
    try {
      var res = wx.getSystemInfoSync().windowWidth;
      var scale = (750 / 2) / (w / 2); //以宽度750px设计稿做宽度的自适应
      real = Math.floor(res / scale);
      return real;
    } catch (e) {
      return false;
      // Do something when catch error
    }
  },
  initEleWidth: function() {
    var delBtnWidth = this.getEleWidth(this.data.delBtnWidth);
    this.setData({
      delBtnWidth: delBtnWidth
    });
  },
  delItem: function(e) {
    var page = this;
    //获取列表中要删除项的下标
    var index = e.target.dataset.index;
    var items = temp_data;
    //移除列表中下标为index的项
    wx.request({
      url: 'http://18.223.126.190/wx.demo/public/api/delete',
      data: {
        'token': getApp().globalData.userInfo.dev_token,
        'usertoken': wx.getStorageSync('usertoken'),
        'articleid': e.target.dataset.id
      },
      method: 'POST',
      header: {
        'content-type': 'application/x-www-form-urlencoded'
      },
      success: function(res) {
        if (res.data.status == 1) {
          wx.showToast({
            title: res.data.message,
            icon: 'loading',
            duration: 1000
          })
          wx.request({
            url: 'http://18.223.126.190/wx.demo/public/api/plist',
            data: {
              'token': getApp().globalData.userInfo.dev_token,
              'usertoken': wx.getStorageSync('usertoken')
            },
            method: 'POST',
            header: {
              'content-type': 'application/x-www-form-urlencoded'
            },
            success: function (res) {
              if (res.data.status == 1) {
                temp_data = JSON.parse(res.data.data);
                for (var i = 0; i < temp_data.length; i++) {
                  temp_data[i].day = formatTime.formatTime(temp_data[i].date, 'dd');
                  temp_data[i].dateDay = formatTime.formatTime(temp_data[i].date, 'D');
                  temp_data[i].date = formatTime.formatTime(temp_data[i].date, 'Y年M月');
                  temp_data[i].txtStyle = "left: 0px";
                }
                page.setData({
                  items: temp_data
                })
              } else {
                wx.showToast({
                  title: res.data.message,
                  icon: 'loading',
                  duration: 2000
                })
              }
            }
          });
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
});