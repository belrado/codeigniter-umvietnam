/***
* auther Bernardo
* email u5ink@naver.com
* homepage http://belrado.cafe24.com/
***/
/*jshint esversion:6*/
'Use strict';
var Calendar = function(year, month, day){
    var date                = (year&&month&&day)?new Date(year, month-1, day):new Date();
    this.currentYear        = date.getFullYear();
    this.currentMonth       = date.getMonth()+1;
    this.currentDate        = date.getDate();
    date.setDate(1);
    this.currentDay         = date.getDay();
    this.calendarId         = 'calendar_wrapper';
    this.calendarDayId      = 'calendar_day';
    this.calendarTableId    = 'calendar_table';
    this.prevBtnId          = 'prevBtn';
    this.nextBtnId          = 'nextBtn';
};
Calendar.prototype = {
    getIsEventCheck:function(id){
        return $._data(document.getElementById(id), "events");
    },
    getDayNum:function(date){
        try{
            date.setDate(1);
            return date.getDay();
        }catch(err){console.log(err);}
    },
    getLastDate:function(currentYear, currentMonth){
        return ( new Date( currentYear, currentMonth, 0) ).getDate();
    },
    setCallbackFnc:function(arg, __this, msg){
        var _this = __this||this;
        var callback = null;
        if(typeof arg[arg.length-1] === 'function'){
            callback = arg[arg.length-1];
        }
        if(typeof callback === 'function'){
            callback(_this, msg);
        }
    },
    setReCalendarDate:function(viewDay){
        if(viewDay == 'next'){
            this.currentYear   = (this.currentMonth < 12)?this.currentYear:this.currentYear+1;
            this.currentMonth  = (this.currentMonth < 12)?this.currentMonth +1:1;
        }else{
            this.currentYear   = (this.currentMonth > 1)?this.currentYear:this.currentYear-1;
            this.currentMonth  = (this.currentMonth > 1)?this.currentMonth -1:12;
        }
        var date               = new Date(this.currentYear, this.currentMonth-1, this.currentDate);
        date.setDate(1);
        this.currentDay        = date.getDay();
    },
    setBtnEvent:function(e){
        e.preventDefault();
        var _this    = e.data._this;
        var btn      = $(this);
        var calendar = $('#'+_this.calendarTableId);
        if(!btn.hasClass('is_animation')){
            btn.addClass('is_animation');
            _this.setReCalendarDate(e.data.action);
            _this.setCalendar(function(){
                if(arguments[1]){
                    $('#'+_this.calendarDayId).text(_this.currentYear+'년 '+_this.currentMonth+'월');
                    calendar.addClass(e.data.action);
                    setTimeout(function(){
                        calendar.removeClass(e.data.action);
                        btn.removeClass('is_animation');
                    },400);
                }
            });
        }
    },
    setPrevBtn:function(id){
        var _this = this;
        var elem_id = id||'prevBtn';
        if(this.getIsEventCheck(elem_id)){
            $('#'+elem_id).off('click');
        }
        $('#'+elem_id).on('click',{'_this':this, 'action':'prev'}, this.setBtnEvent);
    },
    setNextBtn:function(id){
        var _this = this;
        var elem_id = id||'nextBtn';
        if(this.getIsEventCheck(elem_id)){
            $('#'+elem_id).off('click');
        }
        $('#'+elem_id).on('click',{'_this':this, 'action':'next'}, this.setBtnEvent);
    },
    setCalendarHtml:function(lastDate, dateNum){
        var calendar_html    = '<tbody>';
        for(var i=0; i<6; i++){
            calendar_html   += '<tr>';
            for(var j=0; j<7; j++, dateNum++){
                if(dateNum < 1 || dateNum > lastDate){
                    calendar_html +='<td>&nbsp;</td>';
                    continue;
                }
                calendar_html +='<td class="'+((j===0)?'sunday ':'')+((j===6)?'saturday':'')+' '+((dateNum === this.currentDate)?'today':'')+'">'+dateNum+'</td>';
            }
            calendar_html   += '</tr>';
        }
        calendar_html       += '</tbody>';
        return calendar_html;
    },
    setCalendar:function(){
        var returnCheck = false;
        try{
            var lastDate        = this.getLastDate(this.currentYear, this.currentMonth);
            var week            = Math.ceil((this.currentDay+lastDate)/7);
            var dateNum         = 1 - this.currentDay;
            var calendar_html   = this.setCalendarHtml(lastDate, dateNum);
            var calendar_table  = $('#'+this.calendarTableId);
            calendar_table.find('tbody').remove();
            calendar_table.append(calendar_html);
            returnCheck = true;
        }catch(e){}
        this.setCallbackFnc(arguments, this, returnCheck);
    },
    init:function(){
        this.setCalendar();
        this.setPrevBtn();
        this.setNextBtn();
    }
};
