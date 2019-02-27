//index.js
//获取应用实例
var app = getApp()
Page({
  data: {
    animationData: {}
  },
  onShow: function(){
    var animation = wx.createAnimation({
      duration: 1000,
        timingFunction: 'ease',
    })

    this.animation = animation
    this.setData({
      animationData:animation.export()
    })

    setTimeout(function() {
      animation.translate(30).step()
      this.setData({
        animationData:animation.export()
      })
    }.bind(this), 1000)
  },
  rotateAndScale: function () {
    // 旋转
    this.animation.rotate(45).step()
    this.setData({
      animationData: this.animation.export()
    })
  },
  TranslateLeft: function () {
    // 左
    this.animation.translate(100, 0).step({ duration: 1000 })
    this.setData({
      animationData: this.animation.export()
    })
  },
  TranslateRight: function () {
    // 然后平移
    this.animation.translate(300, 0).step({ duration: 1000 })
    this.setData({
      animationData: this.animation.export()
    })
  }
})
