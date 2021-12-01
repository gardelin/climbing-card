(function ( jQuery ) {
  var methods = {
    // jQuery([1,2,3]).collect(function() { return this * this }) // => [1, 4, 9]
    collect: function(enumerable, callback) {
      var result = [];
      jQuery.each(enumerable, function(index) {
        result.push(callback.call(this, index));
      });
      return result;
    },

    // jQuery([1,2,3]).inject(0, function(a) { return a + this }) // => 6
    inject: function(enumerable, initialValue, callback) {
      var accumulator = initialValue;

      jQuery.each(enumerable, function (index) {
        accumulator = callback.call(this, accumulator, index);
      });
      return accumulator;
    },

    // jQuery([1,2,3]).select(function() { return this % 2 == 1 }) // => [1, 3]
    select: function(enumerable, callback) {
      var result = [];
      jQuery.each(enumerable, function(index) {
        if (callback.call(this, index))
          result.push(this);
      });
      return result;
    },

    // jQuery([1,2,3]).reject(function() { return this % 2 == 1 }) // => [2]
    reject: function(enumerable, callback) {
      return jQuery.select(enumerable, negate(callback));
    },

    // jQuery([1,2]).any(function() { return this == 1 }) // => true
    any: function(enumerable, callback) {
      return jQuery.inject(enumerable, false, function(accumulator, index) {
        return accumulator || callback.call(this, index);
      });
    },

    // jQuery([1,1]).any(function() { return this == 1 }) // => true
    all: function(enumerable, callback) {
      return jQuery.inject(enumerable, true, function(accumulator, index) {
        return accumulator && callback.call(this, index);
      });
    },

    // jQuery([1,2,3]).sum() // => 6
    sum: function(enumerable) {
      return jQuery.inject(enumerable, 0, function(accumulator) {
        return accumulator + this;
      });
    }
  };

  var staticFunctions = {};
  var iteratorFunctions = {};
  jQuery.each( methods, function(name, f){ 
    staticFunctions[name]   = makeStaticFunction(f);
    iteratorFunctions[name] = makeIteratorFunction(staticFunctions[name]);
  });
  jQuery.extend(staticFunctions);
  jQuery.fn.extend(iteratorFunctions);

  // Private methods
  function makeStaticFunction(f) {
    return function() {
      if (arguments.length > 1) // The first argument is the enumerable
        validateCallback(arguments[arguments.length - 1]);

      return f.apply(this, arguments);
    }
  }

  function makeIteratorFunction(staticFunction) {
    return function() {
      // arguments isn't a real array, concat doesn't work
      // unless you explicitly convert it
      function toArray() {
        var result = []
        for (var i = 0; i < this.length; i++)
          result.push(this[i])
        return(result)
      }
      return staticFunction.apply(this, [this].concat(toArray.apply(arguments)))
    }
  }

  function validateCallback(callback) {
    if (!jQuery.isFunction(callback))
      throw("callback needs to be a function, it was: " + callback);
  }

  function negate(f) {
    return function() { 
      return !f.apply(this, arguments)
    }
  }
})( jQuery );
