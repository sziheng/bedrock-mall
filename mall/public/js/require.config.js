$(function(){
    requirejs.config({
        shim: {
            'vaildate' : ['jquery'],
            'jquery.ui': ['jquery'],
            'util' : ['jquery'],
            'fileUploader' : ['jquery'],
            'bootstrap' : ['jquery'],
            'echarts' : ['jquery'],
            'datetimepicker' : ['jquery'],
            'select2'  : ['jquery']
        },
        paths : {
            'jquery' : '/vendors/jquery/dist/jquery.min',
            'vaildate' : '/js/jquery.validate.min',
            'jquery.ui' : '/js/jquery-ui-1.10.3.min',
            'bootstrap' : '/vendors/bootstrap/dist/js/bootstrap.min',
            'util' : '/upload/util',
            'fileUploader' : '/upload/fileUploader',
            'echarts'  : '/echarts/echarts-all',
            'datetimepicker' : '/resource/datetimepicker/jquery.datetimepicker',
            'select2' : '/js/select2.min',
        }
    });
})