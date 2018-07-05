/*
 * This combined file was created by the DataTables downloader builder:
 *   https://datatables.net/download
 *
 * To rebuild or modify this file with the latest versions of the included
 * software please visit:
 *   https://datatables.net/download/#dt/pdfmake-0.1.18,dt-1.10.8,af-2.0.0,b-1.0.1,b-colvis-1.0.1,b-flash-1.0.1,b-html5-1.0.1,b-print-1.0.1,cr-1.2.0,fc-3.1.0,fh-3.0.0,kt-2.0.0,r-1.0.7,rr-1.0.0,sc-1.3.0,se-1.0.0
 *
 * Included libraries:
 *   pdfmake 0.1.18, DataTables 1.10.8, AutoFill 2.0.0, Buttons 1.0.1, Column visibility 1.0.1, Flash export 1.0.1, HTML5 export 1.0.1, Print view 1.0.1, ColReorder 1.2.0, FixedColumns 3.1.0, FixedHeader 3.0.0, KeyTable 2.0.0, Responsive 1.0.7, RowReorder 1.0.0, Scroller 1.3.0, Select 1.0.0
 */

/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};

/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {

/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId])
/******/ 			return installedModules[moduleId].exports;

/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			exports: {},
/******/ 			id: moduleId,
/******/ 			loaded: false
/******/ 		};

/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);

/******/ 		// Flag the module as loaded
/******/ 		module.loaded = true;

/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}


/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;

/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;

/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";

/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(0);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ function(module, exports, __webpack_require__) {

	/* WEBPACK VAR INJECTION */(function(global) {module.exports = global["pdfMake"] = __webpack_require__(1);
	/* WEBPACK VAR INJECTION */}.call(exports, (function() { return this; }())))

/***/ },
/* 1 */
/***/ function(module, exports, __webpack_require__) {

	/* WEBPACK VAR INJECTION */(function(Buffer) {/* jslint node: true */
	/* jslint browser: true */
	/* global BlobBuilder */
	'use strict';

	var PdfPrinter = __webpack_require__(2);
	var saveAs = __webpack_require__(3);

	var defaultClientFonts = {
		Roboto: {
			normal: 'Roboto-Regular.ttf',
			bold: 'Roboto-Medium.ttf',
			italics: 'Roboto-Italic.ttf',
			bolditalics: 'Roboto-Italic.ttf'
		}
	};

	function Document(docDefinition, fonts, vfs) {
		this.docDefinition = docDefinition;
		this.fonts = fonts || defaultClientFonts;
		this.vfs = vfs;
	}

	Document.prototype._createDoc = function(options, callback) {
		var printer = new PdfPrinter(this.fonts);
		printer.fs.bindFS(this.vfs);

		var doc = printer.createPdfKitDocument(this.docDefinition, options);
		var chunks = [];
		var result;

		doc.on('data', function(chunk) {
			chunks.push(chunk);
		});
		doc.on('end', function() {
			result = Buffer.concat(chunks);
			callback(result, doc._pdfMakePages);
		});
		doc.end();
	};

	Document.prototype._getPages = function(options, cb){
	  if (!cb) throw 'getBuffer is an async method and needs a callback argument';
	  this._createDoc(options, function(ignoreBuffer, pages){
	    cb(pages);
	  });
	};

	Document.prototype.open = function(message) {
		// we have to open the window immediately and store the reference
		// otherwise popup blockers will stop us
		var win = window.open('', '_blank');

		try {
			this.getDataUrl(function(result) {
				win.location.href = result;
			});
		} catch(e) {
			win.close();
			throw e;
		}
	};


	Document.prototype.print = function() {
	  this.getDataUrl(function(dataUrl) {
	    var iFrame = document.createElement('iframe');
	    iFrame.style.position = 'absolute';
	    iFrame.style.left = '-99999px';
	    iFrame.src = dataUrl;
	    iFrame.onload = function() {
	      function removeIFrame(){
	        document.body.removeChild(iFrame);
	        document.removeEventListener('click', removeIFrame);
	      }
	      document.addEventListener('click', removeIFrame, false);
	    };

	    document.body.appendChild(iFrame);
	  }, { autoPrint: true });
	};

	Document.prototype.download = function(defaultFileName, cb) {
	   if(typeof defaultFileName === "function") {
	      cb = defaultFileName;
	      defaultFileName = null;
	   }

	   defaultFileName = defaultFileName || 'file.pdf';
	   this.getBuffer(function(result) {
	       saveAs(new Blob([result], {type: 'application/pdf'}), defaultFileName);
	       if (typeof cb === "function") {
	           cb();
	       }
	   });
	};

	Document.prototype.getBase64 = function(cb, options) {
		if (!cb) throw 'getBase64 is an async method and needs a callback argument';
		this._createDoc(options, function(buffer) {
			cb(buffer.toString('base64'));
		});
	};

	Document.prototype.getDataUrl = function(cb, options) {
		if (!cb) throw 'getDataUrl is an async method and needs a callback argument';
		this._createDoc(options, function(buffer) {
			cb('data:application/pdf;base64,' + buffer.toString('base64'));
		});
	};

	Document.prototype.getBuffer = function(cb, options) {
		if (!cb) throw 'getBuffer is an async method and needs a callback argument';
		this._createDoc(options, function(buffer){
	    cb(buffer);
	  });
	};

	module.exports = {
		createPdf: function(docDefinition) {
			return new Document(docDefinition, window.pdfMake.fonts, window.pdfMake.vfs);
		}
	};

	/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__(4).Buffer))

/***/ },
/* 2 */
/***/ function(module, exports, __webpack_require__) {

	/* jslint node: true */
	/* global window */
	'use strict';

	var _ = __webpack_require__(11);
	var FontProvider = __webpack_require__(5);
	var LayoutBuilder = __webpack_require__(6);
	var PdfKit = __webpack_require__(28);
	var PDFReference = __webpack_require__(12);
	var sizes = __webpack_require__(7);
	var ImageMeasure = __webpack_require__(8);
	var textDecorator = __webpack_require__(9);
	var FontProvider = __webpack_require__(5);

	////////////////////////////////////////
	// PdfPrinter

	/**
	 * @class Creates an instance of a PdfPrinter which turns document definition into a pdf
	 *
	 * @param {Object} fontDescriptors font definition dictionary
	 *
	 * @example
	 * var fontDescriptors = {
	 *	Roboto: {
	 *		normal: 'fonts/Roboto-Regular.ttf',
	 *		bold: 'fonts/Roboto-Medium.ttf',
	 *		italics: 'fonts/Roboto-Italic.ttf',
	 *		bolditalics: 'fonts/Roboto-Italic.ttf'
	 *	}
	 * };
	 *
	 * var printer = new PdfPrinter(fontDescriptors);
	 */
	function PdfPrinter(fontDescriptors) {
		this.fontDescriptors = fontDescriptors;
	}

	/**
	 * Executes layout engine for the specified document and renders it into a pdfkit document
	 * ready to be saved.
	 *
	 * @param {Object} docDefinition document definition
	 * @param {Object} docDefinition.content an array describing the pdf structure (for more information take a look at the examples in the /examples folder)
	 * @param {Object} [docDefinition.defaultStyle] default (implicit) style definition
	 * @param {Object} [docDefinition.styles] dictionary defining all styles which can be used in the document
	 * @param {Object} [docDefinition.pageSize] page size (pdfkit units, A4 dimensions by default)
	 * @param {Number} docDefinition.pageSize.width width
	 * @param {Number} docDefinition.pageSize.height height
	 * @param {Object} [docDefinition.pageMargins] page margins (pdfkit units)
	 *
	 * @example
	 *
	 * var docDefinition = {
	 *	content: [
	 *		'First paragraph',
	 *		'Second paragraph, this time a little bit longer',
	 *		{ text: 'Third paragraph, slightly bigger font size', fontSize: 20 },
	 *		{ text: 'Another paragraph using a named style', style: 'header' },
	 *		{ text: ['playing with ', 'inlines' ] },
	 *		{ text: ['and ', { text: 'restyling ', bold: true }, 'them'] },
	 *	],
	 *	styles: {
	 *		header: { fontSize: 30, bold: true }
	 *	}
	 * }
	 *
	 * var pdfDoc = printer.createPdfKitDocument(docDefinition);
	 *
	 * pdfDoc.pipe(fs.createWriteStream('sample.pdf'));
	 * pdfDoc.end();
	 *
	 * @return {Object} a pdfKit document object which can be saved or encode to data-url
	 */
	PdfPrinter.prototype.createPdfKitDocument = function(docDefinition, options) {
		options = options || {};

		var pageSize = pageSize2widthAndHeight(docDefinition.pageSize || 'a4');

	  if(docDefinition.pageOrientation === 'landscape') {
	    pageSize = { width: pageSize.height, height: pageSize.width};
	  }
		pageSize.orientation = docDefinition.pageOrientation === 'landscape' ? docDefinition.pageOrientation : 'portrait';

		this.pdfKitDoc = new PdfKit({ size: [ pageSize.width, pageSize.height ], compress: false});
		this.pdfKitDoc.info.Producer = 'pdfmake';
		this.pdfKitDoc.info.Creator = 'pdfmake';
		this.fontProvider = new FontProvider(this.fontDescriptors, this.pdfKitDoc);

	  docDefinition.images = docDefinition.images || {};

		var builder = new LayoutBuilder(
			pageSize,
			fixPageMargins(docDefinition.pageMargins || 40),
	        new ImageMeasure(this.pdfKitDoc, docDefinition.images));

	  registerDefaultTableLayouts(builder);
	  if (options.tableLayouts) {
	    builder.registerTableLayouts(options.tableLayouts);
	  }

		var pages = builder.layoutDocument(docDefinition.content, this.fontProvider, docDefinition.styles || {}, docDefinition.defaultStyle || { fontSize: 12, font: 'Roboto' }, docDefinition.background, docDefinition.header, docDefinition.footer, docDefinition.images, docDefinition.watermark, docDefinition.pageBreakBefore);

		renderPages(pages, this.fontProvider, this.pdfKitDoc);

		if(options.autoPrint){
	        var jsRef = this.pdfKitDoc.ref({
				S: 'JavaScript',
				JS: new StringObject('this.print\\(true\\);')
			});
			var namesRef = this.pdfKitDoc.ref({
				Names: [new StringObject('EmbeddedJS'), new PDFReference(this.pdfKitDoc, jsRef.id)],
			});

			jsRef.end();
			namesRef.end();

			this.pdfKitDoc._root.data.Names = {
				JavaScript: new PDFReference(this.pdfKitDoc, namesRef.id)
			};
		}
		return this.pdfKitDoc;
	};

	function fixPageMargins(margin) {
	    if (!margin) return null;

	    if (typeof margin === 'number' || margin instanceof Number) {
	        margin = { left: margin, right: margin, top: margin, bottom: margin };
	    } else if (margin instanceof Array) {
	        if (margin.length === 2) {
	            margin = { left: margin[0], top: margin[1], right: margin[0], bottom: margin[1] };
	        } else if (margin.length === 4) {
	            margin = { left: margin[0], top: margin[1], right: margin[2], bottom: margin[3] };
	        } else throw 'Invalid pageMargins definition';
	    }

	    return margin;
	}

	function registerDefaultTableLayouts(layoutBuilder) {
	  layoutBuilder.registerTableLayouts({
	    noBorders: {
	      hLineWidth: function(i) { return 0; },
	      vLineWidth: function(i) { return 0; },
	      paddingLeft: function(i) { return i && 4 || 0; },
	      paddingRight: function(i, node) { return (i < node.table.widths.length - 1) ? 4 : 0; },
	    },
	    headerLineOnly: {
	      hLineWidth: function(i, node) {
	        if (i === 0 || i === node.table.body.length) return 0;
	        return (i === node.table.headerRows) ? 2 : 0;
	      },
	      vLineWidth: function(i) { return 0; },
	      paddingLeft: function(i) {
	        return i === 0 ? 0 : 8;
	      },
	      paddingRight: function(i, node) {
	        return (i === node.table.widths.length - 1) ? 0 : 8;
	      }
	    },
	    lightHorizontalLines: {
	      hLineWidth: function(i, node) {
	        if (i === 0 || i === node.table.body.length) return 0;
	        return (i === node.table.headerRows) ? 2 : 1;
	      },
	      vLineWidth: function(i) { return 0; },
	      hLineColor: function(i) { return i === 1 ? 'black' : '#aaa'; },
	      paddingLeft: function(i) {
	        return i === 0 ? 0 : 8;
	      },
	      paddingRight: function(i, node) {
	        return (i === node.table.widths.length - 1) ? 0 : 8;
	      }
	    }
	  });
	}

	var defaultLayout = {
	  hLineWidth: function(i, node) { return 1; }, //return node.table.headerRows && i === node.table.headerRows && 3 || 0; },
	  vLineWidth: function(i, node) { return 1; },
	  hLineColor: function(i, node) { return 'black'; },
	  vLineColor: function(i, node) { return 'black'; },
	  paddingLeft: function(i, node) { return 4; }, //i && 4 || 0; },
	  paddingRight: function(i, node) { return 4; }, //(i < node.table.widths.length - 1) ? 4 : 0; },
	  paddingTop: function(i, node) { return 2; },
	  paddingBottom: function(i, node) { return 2; }
	};

	function pageSize2widthAndHeight(pageSize) {
	    if (typeof pageSize == 'string' || pageSize instanceof String) {
	        var size = sizes[pageSize.toUpperCase()];
	        if (!size) throw ('Page size ' + pageSize + ' not recognized');
	        return { width: size[0], height: size[1] };
	    }

	    return pageSize;
	}

	function StringObject(str){
		this.isString = true;
		this.toString = function(){
			return str;
		};
	}

	function updatePageOrientationInOptions(currentPage, pdfKitDoc) {
		var previousPageOrientation = pdfKitDoc.options.size[0] > pdfKitDoc.options.size[1] ? 'landscape' : 'portrait';

		if(currentPage.pageSize.orientation !== previousPageOrientation) {
			var width = pdfKitDoc.options.size[0];
			var height = pdfKitDoc.options.size[1];
			pdfKitDoc.options.size = [height, width];
		}
	}

	function renderPages(pages, fontProvider, pdfKitDoc) {
	  pdfKitDoc._pdfMakePages = pages;
		for (var i = 0; i < pages.length; i++) {
			if (i > 0) {
				updatePageOrientationInOptions(pages[i], pdfKitDoc);
				pdfKitDoc.addPage(pdfKitDoc.options);
			}

			var page = pages[i];
	    for(var ii = 0, il = page.items.length; ii < il; ii++) {
	        var item = page.items[ii];
	        switch(item.type) {
	          case 'vector':
	              renderVector(item.item, pdfKitDoc);
	              break;
	          case 'line':
	              renderLine(item.item, item.item.x, item.item.y, pdfKitDoc);
	              break;
	          case 'image':
	              renderImage(item.item, item.item.x, item.item.y, pdfKitDoc);
	              break;
					}
	    }
	    if(page.watermark){
	      renderWatermark(page, pdfKitDoc);
		}

	    fontProvider.setFontRefsToPdfDoc();
	  }
	}

	function renderLine(line, x, y, pdfKitDoc) {
		x = x || 0;
		y = y || 0;

		var ascenderHeight = line.getAscenderHeight();

		textDecorator.drawBackground(line, x, y, pdfKitDoc);

		//TODO: line.optimizeInlines();
		for(var i = 0, l = line.inlines.length; i < l; i++) {
			var inline = line.inlines[i];

			pdfKitDoc.fill(inline.color || 'black');

			pdfKitDoc.save();
			pdfKitDoc.transform(1, 0, 0, -1, 0, pdfKitDoc.page.height);


	    var encoded = inline.font.encode(inline.text);
			pdfKitDoc.addContent('BT');

			pdfKitDoc.addContent('' + (x + inline.x) + ' ' + (pdfKitDoc.page.height - y - ascenderHeight) + ' Td');
			pdfKitDoc.addContent('/' + encoded.fontId + ' ' + inline.fontSize + ' Tf');

	        pdfKitDoc.addContent('<' + encoded.encodedText + '> Tj');

			pdfKitDoc.addContent('ET');
			pdfKitDoc.restore();
		}

		textDecorator.drawDecorations(line, x, y, pdfKitDoc);

	}

	function renderWatermark(page, pdfKitDoc){
		var watermark = page.watermark;

		pdfKitDoc.fill('black');
		pdfKitDoc.opacity(0.6);

		pdfKitDoc.save();
		pdfKitDoc.transform(1, 0, 0, -1, 0, pdfKitDoc.page.height);

		var angle = Math.atan2(pdfKitDoc.page.height, pdfKitDoc.page.width) * 180/Math.PI;
		pdfKitDoc.rotate(angle, {origin: [pdfKitDoc.page.width/2, pdfKitDoc.page.height/2]});

	  var en