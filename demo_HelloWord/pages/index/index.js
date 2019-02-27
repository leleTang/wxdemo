//index.js
//获取应用实例
const app = getApp()

Page({
  onReady:function(e){
    //使用wx.createAudioContext获取audio上下文context
    this.audioCtx=wx.createAudioContext('myAudio')
  },
  data: {
    poster:'http://p1.music.126.net/6y-UleORITEDbvrOLV0Q8A==/5639395138885805.jpg',
    name:'身骑白马',
    author:'徐佳莹',
    src:'http://m2.music.126.net/9Py8jhtwE3vDfV_regBavQ==/5964850581190727.mp3',
  },
  audioPlay:function(){
    this.audioCtx.play()
  },
  audioPause: function () {
    this.audioCtx.pause()
  },
  audio30: function () {
    this.audioCtx.seek(30)
  }

})
