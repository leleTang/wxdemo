//index.js
//获取应用实例
var app = getApp()
Page({
  data: {
    array: ['选择1', '选择2', '选择3', '选择4'],
    index: 0,
    date: '2016-11-30',
    time: '22:00'
  },
  bindPickerChange: function(e) {
    console.log('picker发送选择改变，携带值为', e.detail.value)
    this.setData({
      index: e.detail.value
    })
  },
  bindDateChange: function(e) {
    this.setData({
      date: e.detail.value
    })
  },
  bindTimeChange: function(e) {
    this.setData({
      time: e.detail.value
    })
  }
})