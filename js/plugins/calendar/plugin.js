var Calendar = new Class({

	Implements: [Options, Events],

	options: {
      monthLength : [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31],
      monthLengthLeap : [31, 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31],
      preceedingZeros: false
	},

   // METHOD :: Initializes the calendar
	initialize: function(elDay, elMonth, elYear, options) {

		this.elDay   = $(elDay);
		this.elMonth = $(elMonth);
		this.elYear  = $(elYear);
      this.calendar = this.getCalendarTable();

		this.elDay.addEvent('focus', this.show.bind(this));
		this.elMonth.addEvent('focus', this.show.bind(this));
		this.elYear.addEvent('focus', this.show.bind(this));
	   $(document.body).addEvent('click', this.docClick.bind(this));

	},

   // METHOD :: Handles clicks on document
   docClick: function (e) {

      if (e.target == this.elDay || e.target == this.elMonth || e.target == this.elYear) {
         return false;
      }

      if ($(e.target).getParents().indexOf(this.calendar) == -1) {
         this.hide();
      }
   },

   // METHOD :: Handles clicks on calendar
   calClick: function (e) {

      if (e.target.innerHTML.length > 2) {
         return false;
      }

      this.elDay.value   = this._getValue(e.target.innerHTML);
      this.elMonth.value = this._getValue(this.current.getMonth() + 1);
      this.elYear.value  = this.current.getFullYear();

      this.fireEvent('change');
      this.hide();
   },

   // METHOD :: Hides the calendar
   hide : function() {
      if (this.calendar.isVisible()) {
         this.calendar.dissolve();
      }
   },

   // METHOD :: Shows the calendar
   show : function(e) {

      e.stopPropagation();

      if (this.calendar.isVisible()) {
         return false;
      }

      this.current = this.toDate();
      this._update();
      this._position();
      this.calendar.reveal();
   },

   // METHOD :: Shows previous month
   prevMonth: function() {
      this.current.setMonth(this.current.getMonth() - 1);
      this._update();
   },

   // METHOD :: Shows next month
   nextMonth: function() {
      this.current.setMonth(this.current.getMonth() + 1);
      this._update();
   },

   // METHOD :: Updates the calendar
   _update : function() {

      var now           = new Date();
      var cVal          = this.toDate();
          cVal          = cVal < now ? now : cVal;
      var cDate         = this.current.getDay();
      var cYear         = this.current.getFullYear();
      var cMonth        = this.current.getMonth();

      cMonthStart = new Date(this.current.getTime());
      cMonthStart.setDate(1);
      cMonthStart = cMonthStart.getDay();
      cMonthStart = cMonthStart ? cMonthStart : 7;
      var cMonthLength  = this._getDays(cMonth, cYear);

      var oArr = this.calendar.getElements('td');
      for (var i = 1; i <= 42; i++) {
         var cObj = oArr[i - 1];

         // Outside current month
         if (i < cMonthStart || i + 1 > cMonthStart + cMonthLength) {
            cObj.className = 'empty';
            cObj.innerHTML = '&nbsp;';
            cObj.onclick = null;
            continue;
         }

         // addEVent...
         cObj.addEvent('click', this.calClick.bind(this));
         cObj.innerHTML = i - cMonthStart + 1;

         // Current day
         if (i - cMonthStart + 1 == cVal.getDate() && cMonth == cVal.getMonth() && cYear == cVal.getFullYear()) {
            cObj.className = 'current';
            continue;
         }

         cObj.className = 'date';
      }

      var yearBox = this.calendar.getElements('th.yearBox');
      cMonth = XLang.months[cMonth].substr(0, 3).toUpperCase();
      yearBox[0].empty().appendText(cMonth + ' ' + cYear);
   },

   // METHOD :: Positions calendar relative to given boxes (year)
   _position: function() {
      this.calendar.position({
         relativeTo: this.elYear,
         position: 'topRight',
         edge: 'topLeft',
         offset: {x: 5, y: 0}
      });
   },

   // METHOD :: Creates and returns the calendar table
	getCalendarTable : function() {

      var cDv;

      var cTb = new Element('table', {
         'class' : 'xCalBox',
         'cellpadding' : 1
      });
      $(document.body).grab(cTb.hide());

      var cBody = new Element('tbody');

         // Fields: prev, month, next
         cDv = new Element('tr', {
            'class' : 'header'
         });

            cDv.grab(new Element('th', {
               'class' : 'button',
               'html' : '&lt;'
            }).addEvent('click', this.prevMonth.bind(this)));

            cDv.grab(new Element('th', {
               'class' : 'yearBox',
               'colspan' : 5
            }));

            cDv.grab(new Element('th', {
               'class' : 'button',
               'html' : '&gt;'
            }).addEvent('click', this.nextMonth.bind(this)));

         cBody.grab(cDv);

         // Fields: weeks
         cDv = new Element('tr', {
            'class' : 'weekBar'
         });

            var cWeek;
            for(var i = 0; i < 7; i++) {
               cWeek = XLang.days[i].substr(0, 1);
               cDv.grab(new Element('th').appendText(cWeek));
            }

         cBody.grab(cDv);


         // Fields: days
         for(var i = 1; i < 7; i++) {
            var cDv = new Element('tr', {
               'class' : 'dateBar'
            }).inject(cBody);

            for(var j = 1; j < 8; j++) {
               cDv.grab(new Element('td'));
            }
         }

         cTb.grab(cBody);

      return cTb;
	},

   // METHOD :: Returns given value with preceeding zero (max length 2)
   _getValue : function(n) {

      if (this.options.preceedingZeros) {
         return ('0' + n).slice(-2);
      }

      return n;
   },

   // METHOD :: Returns the currently set Date
	toDate: function() {

	   var now = new Date();
	   now.setMonth(parseInt(this.elMonth.value, 10) - 1);
	   now.setDate(parseInt(this.elDay.value, 10));
	   now.setYear(parseInt(this.elYear.value, 10));

      return now;
	},

   // METHOD :: Returns the amount of days for given month/year
   _getDays: function(month, year) {

      if ((year % 4) == 0) {
         return this.options.monthLengthLeap[month];
      }

      return this.options.monthLength[month];
   }
});

new Asset.css((XAdmin ? '../' : '') + 'js/plugins/calendar/css/calendar.css', { });