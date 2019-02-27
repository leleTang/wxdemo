//index.js
//获取应用实例
var app = getApp()
Page({
  onReady: function (e) {
    // 使用 wx.createAudioContext 获取 audio 上下文 context
    this.audioCtx = wx.createAudioContext('myAudio')
  },
  data: {
    poster: 'http://hiphotos.baidu.com/%B9%AB%B6%FA/pic/item/6d617b1b8701a18b4e04b9fb9e2f07082a38fed1.jpg',
    name: '身骑白马',
    author: '徐佳莹',
    src: 'http://m2.music.126.net/9Py8jhtwE3vDfV_regBavQ==/5964850581190727.mp3',
  },
  audioPlay: function () {
    this.audioCtx.play()
  },
  audioPause: function () {
    this.audioCtx.pause()
  },
  audio30: function () {
    this.audioCtx.seek(30)
  }
})
