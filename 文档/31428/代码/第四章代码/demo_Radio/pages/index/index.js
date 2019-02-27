//index.js
//获取应用实例
var app = getApp()
Page({
  data: {
    items: [
      {name: 'name1', value: 'name1'},
      {name: 'name2', value: 'name2', checked: 'true'},
      {name: 'name3', value: 'name3'},
    ]
  },
  radioChange: function(e) {
    console.log('value',"=>"+e.detail.value)
  }
})