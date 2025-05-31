import { Pane } from 'https://cdn.jsdelivr.net/npm/tweakpane@4.0.5/dist/tweakpane.min.js'

let pane = null
let currentEl = null
let params = {}

// Undo stack for drag and drop operations
const undoStack = []
const MAX_UNDO_STEPS = 50 // Limit the number of undo steps to prevent memory issues

// Hàm helper để parse giá trị CSS
function parsePixelValue(value) {
    if (typeof value === 'string') {
        return parseInt(value.replace('px', '')) || 0
    }
    return value || 0
}

function rgbToHex(rgb) {
    if (rgb.startsWith('#')) return rgb

    const rgbMatch = rgb.match(/\d+/g)
    if (!rgbMatch) return '#000000'

    return (
        '#' +
        rgbMatch
            .map((x) => {
                const hex = parseInt(x).toString(16)
                return hex.length === 1 ? '0' + hex : hex
            })
            .join('')
    )
}

// Tạo pane chính trong sidebar
function initMainPane() {
    if (pane) {
        pane.dispose()
    }

    pane = new Pane({
        title: 'Style Editor',
        expanded: true,
    })

    document.getElementById('tweakpane-container').appendChild(pane.element)
}

// Tạo controls cho element được chọn
function createControlsForElement(el) {
    if (pane) {
        pane.dispose()
    }

    const computedStyle = getComputedStyle(el)

    // Khởi tạo params với giá trị hiện tại
    params = {
        // Text content
        textContent: el.textContent || el.innerText || '',

        // General
        width: el.style.width || computedStyle.width,
        height: el.style.height || computedStyle.height,

        linkPadding: true,
        paddingTop: parsePixelValue(computedStyle.paddingTop),
        paddingRight: parsePixelValue(computedStyle.paddingRight),
        paddingBottom: parsePixelValue(computedStyle.paddingBottom),
        paddingLeft: parsePixelValue(computedStyle.paddingTop),

        useMarginAuto: false,
        marginTop: parsePixelValue(computedStyle.marginTop),
        marginRight: parsePixelValue(computedStyle.marginRight),
        marginBottom: parsePixelValue(computedStyle.marginBottom),
        marginLeft: parsePixelValue(computedStyle.marginTop),
        linkMargin: true,

        // Flexbox
        display: computedStyle.display,
        flexDirection: computedStyle.flexDirection,
        justifyContent: computedStyle.justifyContent,
        alignItems: computedStyle.alignItems,
        flexWrap: computedStyle.flexWrap,
        gap: parsePixelValue(computedStyle.gap),

        // Typography
        fontSize: parsePixelValue(computedStyle.fontSize),
        fontWeight: computedStyle.fontWeight,
        fontFamily: computedStyle.fontFamily,
        textAlign: computedStyle.textAlign,
        lineHeight: parseFloat(computedStyle.lineHeight) || 1.5,
        letterSpacing: parsePixelValue(computedStyle.letterSpacing),

        // Colors
        textColor: rgbToHex(computedStyle.color),
        backgroundColor: rgbToHex(computedStyle.backgroundColor),
        borderColor: rgbToHex(computedStyle.borderColor),
        borderWidth: parsePixelValue(computedStyle.borderWidth),
        borderStyle: computedStyle.borderStyle,

        // Effects
        borderRadius: parsePixelValue(computedStyle.borderRadius),
        opacity: parseFloat(computedStyle.opacity),
        boxShadow: computedStyle.boxShadow !== 'none',
        shadowBlur: 10,
        shadowSpread: 0,
        shadowColor: '#000000',

        // Image
        imageSrc: el.getAttribute('src') || '',
        imageAlt: el.getAttribute('alt') || '',
    }

    pane = new Pane({
        title: `Editing: ${el.tagName.toLowerCase()}`,
        expanded: true,
    })

    document.getElementById('tweakpane-container').appendChild(pane.element)

    // Make element editable
    makeElementEditable(el)

    // Thêm các folder với event listeners
    addGeneralControls()
    addTextControls()
    addColorControls()
    addEffectsControls()
    addImageControls()
}

function applyStyle(property, value) {
    if (!currentEl) return
    currentEl.style[property] = value + 'px'
}

// Add General
function addGeneralControls() {
    const folder = pane.addFolder({ title: '📐 General', expanded: true })

    // 👉 Width & Height
    folder
        .addBinding(params, 'width', {
            label: 'Width',
            min: 0,
            max: 2000,
            step: 1,
        })
        .on('change', (ev) => {
            if (currentEl) currentEl.style.width = ev.value
        })

    folder
        .addBinding(params, 'height', {
            label: 'Height',
            min: 0,
            max: 2000,
            step: 1,
        })
        .on('change', (ev) => {
            if (currentEl) currentEl.style.height = ev.value
        })

    folder.addBinding(params, 'useMarginAuto', {
        label: 'Margin auto',
    }).on('change', (ev) => {
        if (!currentEl) return

        if (ev.value) {
            currentEl.style.margin = 'auto'
        } else {
            // Trả lại các giá trị margin cụ thể (nếu cần)
            currentEl.style.marginTop = typeof params.marginTop === 'number' ? `${params.marginTop}px` : ''
            currentEl.style.marginRight = typeof params.marginRight === 'number' ? `${params.marginRight}px` : ''
            currentEl.style.marginBottom = typeof params.marginBottom === 'number' ? `${params.marginBottom}px` : ''
            currentEl.style.marginLeft = typeof params.marginLeft === 'number' ? `${params.marginLeft}px` : ''
            currentEl.style.margin = '' // reset nếu cần
        }
    })

    // Link margin
    folder.addBinding(params, 'linkMargin', { label: '🔗 Margin' })

    const marginFields = [
        folder.addBinding(params, 'marginTop', {
            label: 'Top',
            min: -100,
            max: 100,
            step: 1,
        }),
        folder.addBinding(params, 'marginRight', {
            label: 'Right',
            min: -100,
            max: 100,
            step: 1,
        }),
        folder.addBinding(params, 'marginBottom', {
            label: 'Bottom',
            min: -100,
            max: 100,
            step: 1,
        }),
        folder.addBinding(params, 'marginLeft', {
            label: 'Left',
            min: -100,
            max: 100,
            step: 1,
        }),
    ]

    marginFields.forEach((binding, index) => {
        binding.on('change', (ev) => {
            const value = ev.value
            if (params.linkMargin) {
                params.marginTop = value
                params.marginRight = value
                params.marginBottom = value
                params.marginLeft = value
                marginFields.forEach((b) => b.refresh()) // cập nhật UI
            }
            applyStyle('marginTop', params.marginTop)
            applyStyle('marginRight', params.marginRight)
            applyStyle('marginBottom', params.marginBottom)
            applyStyle('marginLeft', params.marginLeft)
        })
    })

    // Link padding
    folder.addBinding(params, 'linkPadding', { label: '🔗 Padding' })

    const paddingFields = [
        folder.addBinding(params, 'paddingTop', {
            label: 'Top',
            min: -100,
            max: 100,
            step: 1,
        }),
        folder.addBinding(params, 'paddingRight', {
            label: 'Right',
            min: -100,
            max: 100,
            step: 1,
        }),
        folder.addBinding(params, 'paddingBottom', {
            label: 'Bottom',
            min: -100,
            max: 100,
            step: 1,
        }),
        folder.addBinding(params, 'paddingLeft', {
            label: 'Left',
            min: -100,
            max: 100,
            step: 1,
        }),
    ]

    paddingFields.forEach((binding, index) => {
        binding.on('change', (ev) => {
            const value = ev.value
            if (params.linkPadding) {
                params.paddingTop = value
                params.paddingRight = value
                params.paddingBottom = value
                params.paddingLeft = value
                paddingFields.forEach((b) => b.refresh())
            }
            applyStyle('paddingTop', params.paddingTop)
            applyStyle('paddingRight', params.paddingRight)
            applyStyle('paddingBottom', params.paddingBottom)
            applyStyle('paddingLeft', params.paddingLeft)
        })
    })

    // Display selector
    folder
        .addBinding(params, 'display', {
            options: {
                Block: 'block',
                Inline: 'inline',
                'Inline-block': 'inline-block',
                Flex: 'flex',
                Grid: 'grid',
                None: 'none',
            },
        })
        .on('change', (ev) => {
            if (currentEl) currentEl.style.display = ev.value
        })

    // Flex Direction
    folder
        .addBinding(params, 'flexDirection', {
            label: 'Flex Direction',
            options: {
                Row: 'row',
                'Row Reverse': 'row-reverse',
                Column: 'column',
                'Column Reverse': 'column-reverse',
            },
        })
        .on('change', (ev) => {
            if (currentEl && params.display === 'flex') {
                currentEl.style.flexDirection = ev.value
            }
        })

    // Justify Content
    folder
        .addBinding(params, 'justifyContent', {
            label: 'Justify Content',
            options: {
                'Flex Start': 'flex-start',
                Center: 'center',
                'Flex End': 'flex-end',
                'Space Between': 'space-between',
                'Space Around': 'space-around',
                'Space Evenly': 'space-evenly',
            },
        })
        .on('change', (ev) => {
            if (currentEl && params.display === 'flex') {
                currentEl.style.justifyContent = ev.value
            }
        })

    // Align Items
    folder
        .addBinding(params, 'alignItems', {
            label: 'Align Items',
            options: {
                Stretch: 'stretch',
                Center: 'center',
                'Flex Start': 'flex-start',
                'Flex End': 'flex-end',
                Baseline: 'baseline',
            },
        })
        .on('change', (ev) => {
            if (currentEl && params.display === 'flex') {
                currentEl.style.alignItems = ev.value
            }
        })

    // Flex Wrap
    folder
        .addBinding(params, 'flexWrap', {
            label: 'Flex Wrap',
            options: {
                Nowrap: 'nowrap',
                Wrap: 'wrap',
                'Wrap Reverse': 'wrap-reverse',
            },
        })
        .on('change', (ev) => {
            if (currentEl && params.display === 'flex') {
                currentEl.style.flexWrap = ev.value
            }
        })

    // Gap (số đơn vị px)
    folder
        .addBinding(params, 'gap', {
            label: 'Gap',
            min: 0,
            max: 100,
            step: 1,
        })
        .on('change', (ev) => {
            if (currentEl && params.display === 'flex') {
                currentEl.style.gap = ev.value + 'px'
            }
        })


}

// Folder text
function addTextControls() {
    const folder = pane.addFolder({ title: '📝 Typography', expanded: true })

    // Text content editor
    if (
        currentEl &&
        currentEl.tagName !== 'INPUT' &&
        currentEl.tagName !== 'TEXTAREA'
    ) {
        folder
            .addBinding(params, 'textContent', { label: 'Text' })
            .on('change', (ev) => {
                if (currentEl) {
                    // Preserve HTML formatting while updating text
                    const htmlContent = ev.value
                        .replace(/\n/g, '<br>')
                        .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
                        .replace(/\*(.*?)\*/g, '<em>$1</em>')
                        .replace(/__(.*?)__/g, '<u>$1</u>')
                        .replace(/~~(.*?)~~/g, '<s>$1</s>')
                    currentEl.innerHTML = htmlContent
                }
            })
    }

    // Rich text formatting buttons
    const textFormatFolder = folder.addFolder({
        title: 'Formatting',
        expanded: false,
    })

    // Bold button
    const boldBtn = textFormatFolder.addButton({ title: 'Toggle Bold (Ctrl+B)' })
    boldBtn.on('click', () => {
        toggleTextFormat('bold')
    })

    // Italic button
    const italicBtn = textFormatFolder.addButton({
        title: 'Toggle Italic (Ctrl+I)',
    })
    italicBtn.on('click', () => {
        toggleTextFormat('italic')
    })

    // Underline button
    const underlineBtn = textFormatFolder.addButton({
        title: 'Toggle Underline (Ctrl+U)',
    })
    underlineBtn.on('click', () => {
        toggleTextFormat('underline')
    })

    // Strike through button
    const strikeBtn = textFormatFolder.addButton({ title: 'Toggle Strike' })
    strikeBtn.on('click', () => {
        toggleTextFormat('strikeThrough')
    })

    // Line break button
    const brBtn = textFormatFolder.addButton({ title: 'Insert Line Break' })
    brBtn.on('click', () => {
        insertAtCursor('<br>')
    })

    // Clear formatting button
    const clearBtn = textFormatFolder.addButton({ title: 'Clear Formatting' })
    clearBtn.on('click', () => {
        if (currentEl) {
            currentEl.innerHTML = currentEl.textContent || currentEl.innerText
        }
    })

    folder
        .addBinding(params, 'fontSize', { min: 8, max: 72 })
        .on('change', (ev) => {
            if (currentEl) currentEl.style.fontSize = ev.value + 'px'
        })

    folder
        .addBinding(params, 'fontWeight', {
            options: {
                Normal: 'normal',
                Bold: 'bold',
                Light: '300',
                Medium: '500',
                'Semi-bold': '600',
                'Extra-bold': '800',
            },
        })
        .on('change', (ev) => {
            if (currentEl) currentEl.style.fontWeight = ev.value
        })

    folder
        .addBinding(params, 'textAlign', {
            options: {
                Left: 'left',
                Center: 'center',
                Right: 'right',
                Justify: 'justify',
            },
        })
        .on('change', (ev) => {
            if (currentEl) currentEl.style.textAlign = ev.value
        })

    folder
        .addBinding(params, 'lineHeight', { min: 0.5, max: 3, step: 0.1 })
        .on('change', (ev) => {
            if (currentEl) currentEl.style.lineHeight = ev.value
        })

    folder
        .addBinding(params, 'letterSpacing', { min: -2, max: 5, step: 0.1 })
        .on('change', (ev) => {
            if (currentEl) currentEl.style.letterSpacing = ev.value + 'px'
        })

    // Font family
    folder
        .addBinding(params, 'fontFamily', {
            options: {
                Arial: 'Arial, sans-serif',
                Helvetica: 'Helvetica, sans-serif',
                'Times New Roman': 'Times New Roman, serif',
                Georgia: 'Georgia, serif',
                Verdana: 'Verdana, sans-serif',
                'Courier New': 'Courier New, monospace',
                'Comic Sans MS': 'Comic Sans MS, cursive',
                Impact: 'Impact, sans-serif',
            },
        })
        .on('change', (ev) => {
            if (currentEl) currentEl.style.fontFamily = ev.value
        })
}

// Toggle text formatting
function toggleTextFormat(command) {
    if (!currentEl) return

    // Make element contentEditable temporarily
    const wasEditable = currentEl.contentEditable
    currentEl.contentEditable = true
    currentEl.focus()

    // Execute formatting command
    document.execCommand(command, false, null)

    // Restore original contentEditable state
    currentEl.contentEditable = wasEditable
    currentEl.blur()
}

// Insert content at cursor position
function insertAtCursor(content) {
    if (!currentEl) return

    const wasEditable = currentEl.contentEditable
    currentEl.contentEditable = true
    currentEl.focus()

    // Get selection
    const sel = window.getSelection()
    if (sel.getRangeAt && sel.rangeCount) {
        const range = sel.getRangeAt(0)
        range.deleteContents()

        // Create content node
        const el = document.createElement('span')
        el.innerHTML = content
        range.insertNode(el)

        // Move cursor after inserted content
        range.setStartAfter(el)
        range.collapse(true)
        sel.removeAllRanges()
        sel.addRange(range)
    }

    currentEl.contentEditable = wasEditable
    currentEl.blur()
}

// Make element editable on double click
function makeElementEditable(el) {
    if (el.tagName === 'INPUT' || el.tagName === 'TEXTAREA') return

    el.addEventListener('dblclick', function (e) {
        e.preventDefault()
        e.stopPropagation()
        this.contentEditable = true
        this.focus()

        // Add editing style
        this.style.outline = '2px dashed #3498db'
        this.style.backgroundColor = 'rgba(52, 152, 219, 0.1)'
        this.style.cursor = 'text'
        this.style.userSelect = 'text'
    })

    el.addEventListener('blur', function () {
        this.contentEditable = false
        this.style.outline = ''
        this.style.backgroundColor = ''
        this.style.cursor = ''
        this.style.userSelect = ''
    })

    el.addEventListener('keydown', function (e) {
        if (e.key === 'Enter' && e.shiftKey) {
            e.preventDefault()
            insertAtCursor('<br>')
        } else if (e.key === 'Escape') {
            this.blur()
        }
    })
}

// Folder màu sắc
function addColorControls() {
    const folder = pane.addFolder({ title: '🎨 Colors', expanded: false })

    folder
        .addBinding(params, 'textColor', {
            label: 'Text',
        })
        .on('change', (ev) => {
            if (currentEl) currentEl.style.color = ev.value
        })

    folder
        .addBinding(params, 'backgroundColor', {
            label: 'Background color',
            color: { type: 'rgba' }
        })
        .on('change', (ev) => {
            if (currentEl) currentEl.style.backgroundColor = ev.value
        })

    // Border color with RGBA support
    folder
        .addBinding(params, 'borderColor', {
            label: 'Border Color',
        })
        .on('change', (ev) => {
            if (currentEl) {
                currentEl.style.borderColor = ev.value
                updateBorderStyle()
            }
        })

    // Border style
    folder
        .addBinding(params, 'borderStyle', {
            label: 'Border Style',
            options: {
                None: 'none',
                Solid: 'solid',
                Dashed: 'dashed',
                Dotted: 'dotted',
                Double: 'double',
            },
        })
        .on('change', (ev) => {
            updateBorderStyle()
        })

    // Border width (in pixels)
    folder
        .addBinding(params, 'borderWidth', {
            label: 'Border Width',
            min: 0,
            max: 20,
            step: 1,
        })
        .on('change', (ev) => {
            updateBorderStyle()
        })

    function updateBorderStyle() {
        if (currentEl) {
            const width = params.borderWidth || 0
            const style = params.borderStyle || 'solid'
            const color = params.borderColor || 'rgba(0,0,0,1)'
            currentEl.style.border = `${width}px ${style} ${color}`
        }
    }
    // Thêm preset colors
    const presetFolder = folder.addFolder({ title: 'Presets', expanded: false })
    const presetParams = { theme: 'default' }

    presetFolder
        .addBinding(presetParams, 'theme', {
            options: {
                Default: 'default',
                Dark: 'dark',
                Blue: 'blue',
                Green: 'green',
                Purple: 'purple',
                Orange: 'orange',
            },
        })
        .on('change', (ev) => {
            applyTheme(ev.value)
        })
}

// Folder hiệu ứng
function addEffectsControls() {
    const folder = pane.addFolder({ title: '✨ Effects', expanded: false })

    folder
        .addBinding(params, 'borderRadius', { min: 0, max: 100, step: 1 })
        .on('change', (ev) => {
            if (currentEl) currentEl.style.borderRadius = ev.value + 'px'
        })

    folder
        .addBinding(params, 'opacity', { min: 0, max: 1, step: 0.01 })
        .on('change', (ev) => {
            if (currentEl) currentEl.style.opacity = ev.value
        })

    folder.addBinding(params, 'boxShadow').on('change', (ev) => {
        updateBoxShadow()
    })

    folder
        .addBinding(params, 'shadowBlur', { min: 0, max: 100, step: 1 })
        .on('change', (ev) => {
            updateBoxShadow()
        })

    folder
        .addBinding(params, 'shadowSpread', { min: -20, max: 20, step: 1 })
        .on('change', (ev) => {
            updateBoxShadow()
        })

    folder.addBinding(params, 'shadowColor').on('change', (ev) => {
        updateBoxShadow()
    })

    // Transform controls
    const transformParams = { transform: 'none' }
    folder
        .addBinding(transformParams, 'transform', {
            label: 'Transform',
            options: {
                None: 'none',
                'Scale Up': 'scale(1.1)',
                'Scale Down': 'scale(0.9)',
                'Rotate 5°': 'rotate(5deg)',
                'Rotate -5°': 'rotate(-5deg)',
                'Rotate 15°': 'rotate(15deg)',
                'Translate X': 'translateX(10px)',
                'Translate Y': 'translateY(10px)',
                'Translate XY': 'translate(10px, 10px)',
                'Skew X': 'skewX(5deg)',
                'Skew Y': 'skewY(5deg)',
                'Skew Both': 'skew(10deg, 5deg)',
                'Flip Horizontal': 'scaleX(-1)',
                'Flip Vertical': 'scaleY(-1)',
                'Combo: Scale + Rotate': 'scale(1.1) rotate(10deg)',
                'Combo: Translate + Rotate': 'translateX(5px) rotate(3deg)',
            },
        })
        .on('change', (ev) => {
            if (currentEl) {
                currentEl.style.transform = ev.value === 'none' ? '' : ev.value
            }
        })

    // Transition
    const transitionParams = { transition: 'all 0.3s ease' }
    folder.addBinding(transitionParams, 'transition').on('change', (ev) => {
        if (currentEl) currentEl.style.transition = ev.value
    })
}

function addImageControls() {
    if (params.imageSrc) {
        const imageFolder = pane.addFolder({ title: '🖼️ Image', expanded: true })

        // Tạo input file ẩn
        const fileInput = document.createElement('input')
        fileInput.type = 'file'
        fileInput.accept = 'image/*'
        fileInput.style.display = 'none'
        document.body.appendChild(fileInput)

        // Tạo ảnh
        const img = document.createElement('img')
        img.src = params.imageSrc
        img.className = 'clickable-image'
        img.style.width = '100%'
        img.style.height = '100px'
        img.style.marginTop = '10px'
        img.style.marginBottom = '10px'
        img.style.objectFit = 'contain'
        img.style.cursor = 'pointer'

        // Khi nhấn vào ảnh → mở chọn file
        img.addEventListener('click', () => {
            fileInput.click()
        })

        // Khi người dùng chọn ảnh
        fileInput.addEventListener('change', (event) => {
            const file = event.target.files[0]
            if (file) {
                const reader = new FileReader()
                reader.onload = function (e) {
                    const newSrc = e.target.result
                    img.src = newSrc
                    params.imageSrc = newSrc
                    // Nếu có currentEl cần cập nhật
                    if (currentEl) currentEl.setAttribute('src', newSrc)
                }
                reader.readAsDataURL(file)
            }
        })

        // Gắn ảnh vào thư mục
        imageFolder.element.appendChild(img)

        // Binding URL và cập nhật ảnh
        imageFolder
            .addBinding(params, 'imageSrc', { label: 'Source URL' })
            .on('change', (ev) => {
                if (currentEl) currentEl.setAttribute('src', ev.value)
                img.src = ev.value
            })

        // Binding alt
        imageFolder
            .addBinding(params, 'imageAlt', { label: 'Alt text' })
            .on('change', (ev) => {
                if (currentEl) currentEl.setAttribute('alt', ev.value)
                img.alt = ev.value
            })
    }
}

// Cập nhật box shadow
function updateBoxShadow() {
    if (currentEl && params.boxShadow) {
        const shadow = `0px 0px ${params.shadowBlur}px ${params.shadowSpread}px ${params.shadowColor}`
        currentEl.style.boxShadow = shadow
    } else if (currentEl) {
        currentEl.style.boxShadow = 'none'
    }
}

// Áp dụng theme
function applyTheme(theme) {
    const themes = {
        dark: { background: '#2c3e50', text: '#ecf0f1', accent: '#3498db' },
        blue: { background: '#3498db', text: '#ffffff', accent: '#2980b9' },
        green: { background: '#2ecc71', text: '#ffffff', accent: '#27ae60' },
        purple: { background: '#9b59b6', text: '#ffffff', accent: '#8e44ad' },
        orange: { background: '#e67e22', text: '#ffffff', accent: '#d35400' },
    }

    if (themes[theme] && currentEl) {
        const t = themes[theme]
        currentEl.style.backgroundColor = t.background
        currentEl.style.color = t.text
        currentEl.style.borderColor = t.accent

        // Cập nhật params để sync với UI
        params.backgroundColor = t.background
        params.textColor = t.text
        params.borderColor = t.accent

        pane.refresh()
    }
}

// Lưu trạng thái hiện tại của các element
function saveCurrentState() {
    const contentEl = document.getElementById('content')
    if (!contentEl) return

    const html = contentEl.innerHTML

    if (undoStack.length >= MAX_UNDO_STEPS) {
        undoStack.shift()
    }

    undoStack.push(html)
    updateUndoButtonState()
}

// Hàm tạo selector duy nhất cho một element
function getElementSelector(el) {
    if (!el) return null;

    // Thử sử dụng ID nếu có
    if (el.id) {
        return `#${el.id}`;
    }

    // Nếu không có ID, tạo selector dựa trên vị trí
    const path = [];
    let current = el;

    while (current && current.nodeType === Node.ELEMENT_NODE && current !== document.body) {
        let selector = current.tagName.toLowerCase();

        // Thêm class nếu có
        if (current.className && typeof current.className === 'string') {
            const classes = current.className.split(/\s+/).filter(c => c.length > 0);
            if (classes.length > 0) {
                selector += '.' + classes.join('.');
            }
        }

        // Thêm thứ tự trong cha
        const parent = current.parentNode;
        if (parent) {
            const siblings = Array.from(parent.children);
            const index = siblings.indexOf(current) + 1;
            if (index > 0) {
                selector += `:nth-child(${index})`;
            }
        }

        path.unshift(selector);

        // Dừng nếu đã đủ thông tin để xác định duy nhất
        if (document.querySelectorAll(selector).length === 1) {
            break;
        }

        current = parent;
    }

    return path.join(' > ');
}

// Hàm tìm element từ selector
function findElementBySelector(selector) {
    if (!selector) return null;
    try {
        const elements = document.querySelectorAll(selector);
        return elements.length > 0 ? elements[0] : null;
    } catch (e) {
        console.error('Invalid selector:', selector, e);
        return null;
    }
}

// Khôi phục trạng thái từ stack
function undoLastAction() {
    if (undoStack.length < 2) return;

    // Lưu lại selector của element đang được chọn (nếu có)
    const selectedSelector = currentEl ? getElementSelector(currentEl) : null;

    // Bỏ trạng thái hiện tại
    undoStack.pop();
    const previousHtml = undoStack[undoStack.length - 1];
    const contentEl = document.getElementById('content');

    if (!contentEl) return;

    // Lưu vị trí scroll
    const scrollTop = contentEl.scrollTop;

    // Khôi phục HTML
    contentEl.innerHTML = previousHtml;

    // Khởi tạo lại các sự kiện
    initDraggable();

    // Khôi phục lại element đang được chọn (nếu có)
    if (selectedSelector) {
        // Đợi một chút để DOM cập nhật
        setTimeout(() => {
            const elementToSelect = findElementBySelector(selectedSelector);
            if (elementToSelect) {
                handleElementClick(elementToSelect);
                // Cuộn đến element nếu cần
                elementToSelect.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            } else {
                // Nếu không tìm thấy element cũ, hủy chọn
                if (currentEl) {
                    currentEl.classList.remove('selected-element');
                    currentEl = null;
                }
                initMainPane();
            }
        }, 10);
    } else {
        // Nếu không có element nào được chọn trước đó, đảm bỏ chọn
        if (currentEl) {
            currentEl.classList.remove('selected-element');
            currentEl = null;
        }
        initMainPane();
    }

    // Khôi phục vị trí scroll
    contentEl.scrollTop = scrollTop;

    updateUndoButtonState();
}


// Cập nhật trạng thái nút undo
function updateUndoButtonState() {
    const undoButton = document.getElementById('undo-button')
    if (undoButton) {
        undoButton.disabled = undoStack.length < 2
    }
}

// Khởi tạo nút undo
function initUndoButton() {
    const undoButton = document.getElementById('undo-button')
    if (undoButton) {
        undoButton.addEventListener('click', () => {
            undoLastAction()
        })
    }

    document.addEventListener('keydown', (e) => {
        if ((e.ctrlKey || e.metaKey) && e.key === 'z') {
            e.preventDefault()
            undoLastAction()
        }
    })

    updateUndoButtonState()
}



// Khởi tạo drag and drop cho các element
function initDraggable() {
    const draggableElements = document.querySelectorAll('#content *')

    draggableElements.forEach((element) => {
        // Đặt thuộc tính draggable
        element.setAttribute('draggable', 'true')

        // Bắt đầu kéo
        element.addEventListener('dragstart', (e) => {
            e.stopPropagation()
            e.dataTransfer.effectAllowed = 'move'
            e.dataTransfer.setData('text/plain', '')
            element.classList.add('dragging')

            setTimeout(() => {
                element.style.pointerEvents = 'none'
            }, 0)
        })

        // Kết thúc kéo
        element.addEventListener('dragend', () => {
            element.classList.remove('dragging')
            element.style.pointerEvents = ''

            document.querySelectorAll(
                '.drag-over-highlight-top, .drag-over-highlight-middle, .drag-over-highlight-bottom'
            ).forEach((el) => {
                el.classList.remove(
                    'drag-over-highlight-top',
                    'drag-over-highlight-middle',
                    'drag-over-highlight-bottom'
                )
            })
        })

        // Khi rê chuột qua phần tử
        element.addEventListener('dragover', (e) => {
            e.preventDefault()
            e.stopPropagation()

            const draggingElement = document.querySelector('.dragging')
            if (!draggingElement || draggingElement === element || element.contains(draggingElement)) return

            const rect = element.getBoundingClientRect()
            const offsetY = e.clientY - rect.top
            const third = rect.height / 3

            element.classList.remove(
                'drag-over-highlight-top',
                'drag-over-highlight-middle',
                'drag-over-highlight-bottom'
            )

            if (offsetY < third) {
                element.classList.add('drag-over-highlight-top')
            } else if (offsetY > 2 * third) {
                element.classList.add('drag-over-highlight-bottom')
            } else {
                element.classList.add('drag-over-highlight-middle')
            }
        })

        // Rời khỏi phần tử
        element.addEventListener('dragleave', () => {
            element.classList.remove(
                'drag-over-highlight-top',
                'drag-over-highlight-middle',
                'drag-over-highlight-bottom'
            )
        })

        // Khi thả
        element.addEventListener('drop', (e) => {
            e.preventDefault()
            e.stopPropagation()

            const draggingElement = document.querySelector('.dragging')
            if (!draggingElement || draggingElement === element || element.contains(draggingElement)) return

            const rect = element.getBoundingClientRect()
            const offsetY = e.clientY - rect.top
            const third = rect.height / 3

            element.classList.remove(
                'drag-over-highlight-top',
                'drag-over-highlight-middle',
                'drag-over-highlight-bottom'
            )

            if (typeof saveCurrentState === 'function') {
                saveCurrentState()
            }

            if (offsetY < third) {
                element.parentNode.insertBefore(draggingElement, element)
            } else if (offsetY > 2 * third) {
                element.parentNode.insertBefore(draggingElement, element.nextSibling)
            } else {
                element.appendChild(draggingElement)
            }

            // Gắn lại sự kiện sau khi DOM thay đổi
            setTimeout(initDraggable, 0)
        })
    })
}



function handleElementClick(el) {
    // Bỏ chọn element cũ nếu có
    if (currentEl) {
        currentEl.classList.remove('selected-element')
    }

    // Chọn element mới
    currentEl = el
    currentEl.classList.add('selected-element')

    // Tạo controls cho element được chọn
    createControlsForElement(el)

    // Cập nhật trạng thái nút link
    updateLinkButtonState()
}

// Xử lý lưu nội dung
function initSaveContent() {
    const $saveButton = $('#save-content')
    if ($saveButton.length === 0) return

    $saveButton.on('click', function () {
        const $contentClone = $('#content').clone()

        // Xóa tất cả class selected-element, attribute draggable, contenteditable
        $contentClone.find('.selected-element').removeClass('selected-element')
        $contentClone
            .find('[draggable], [contenteditable]')
            .addBack('[draggable], [contenteditable]')
            .removeAttr('draggable contenteditable')
        // Lấy HTML sau khi đã xóa class
        const content = $contentClone.html()
        // console.log(content)

        // Hiển thị trạng thái đang lưu
        $saveButton
            .prop('disabled', true)
            .html('<i class="fas fa-spinner fa-spin"></i> Saving...')

        $.ajax({
            url: $('#save-route').val(),
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({ content }),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function (response) {
                // Hiển thị thông báo thành công
                showNotification('Content saved successfully!', 'success')
            },
            error: function (xhr, status, error) {
                console.error('Error saving content:', error)
                showNotification('Error saving content. Please try again.', 'error')
            },
            complete: function () {
                // Khôi phục trạng thái nút
                $saveButton
                    .prop('disabled', false)
                    .html('<i class="fas fa-save"></i> Save Content')
            },
        })
    })
}

// Hiển thị thông báo
function showNotification(message, type = 'success') {
    // Tạo element thông báo
    const notification = document.createElement('div')
    notification.className = `notification ${type}`
    notification.innerHTML = `
        <div class="notification-content">
            <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'
        }"></i>
            <span>${message}</span>
        </div>
    `

    // Thêm vào body
    document.body.appendChild(notification)

    // Hiển thị animation
    setTimeout(() => notification.classList.add('show'), 100)

    // Tự động ẩn sau 3 giây
    setTimeout(() => {
        notification.classList.remove('show')
        setTimeout(() => notification.remove(), 300)
    }, 3000)
}

// Hàm duplicate element
function duplicateElement(element) {
    if (!element) return

    // Clone element
    const clone = element.cloneNode(true)

    // Thêm event listeners cho element mới
    makeElementEditable(clone)

    // Thêm thuộc tính draggable và event listeners cho drag & drop
    clone.setAttribute('draggable', 'true')

    // Thêm event listeners cho drag & drop
    clone.addEventListener('dragstart', (e) => {
        e.stopPropagation()
        e.dataTransfer.effectAllowed = 'move'
        e.dataTransfer.setData('text/plain', '')
        clone.classList.add('dragging')
        setTimeout(() => {
            clone.style.pointerEvents = 'none'
        }, 0)
    })

    clone.addEventListener('dragend', (e) => {
        e.stopPropagation()
        clone.classList.remove('dragging')
        clone.style.pointerEvents = ''
        document
            .querySelectorAll('.drag-over-highlight-top, .drag-over-highlight-bottom')
            .forEach((el) => {
                el.classList.remove(
                    'drag-over-highlight-top',
                    'drag-over-highlight-bottom'
                )
            })
    })

    clone.addEventListener('dragover', (e) => {
        e.preventDefault()
        e.stopPropagation()
        const draggingElement = document.querySelector('.dragging')
        if (!draggingElement) return
        if (draggingElement === clone || clone.contains(draggingElement)) return

        const rect = clone.getBoundingClientRect()
        const midY = rect.top + rect.height / 2

        clone.classList.remove(
            'drag-over-highlight-top',
            'drag-over-highlight-bottom'
        )
        if (e.clientY < midY) {
            clone.classList.add('drag-over-highlight-top')
        } else {
            clone.classList.add('drag-over-highlight-bottom')
        }
    })

    clone.addEventListener('dragleave', (e) => {
        e.stopPropagation()
        clone.classList.remove(
            'drag-over-highlight-top',
            'drag-over-highlight-bottom'
        )
    })

    clone.addEventListener('drop', (e) => {
        e.preventDefault()
        e.stopPropagation()
        const draggingElement = document.querySelector('.dragging')
        if (!draggingElement) return
        if (draggingElement === clone || clone.contains(draggingElement)) return

        const rect = clone.getBoundingClientRect()
        const midY = rect.top + rect.height / 2

        clone.classList.remove(
            'drag-over-highlight-top',
            'drag-over-highlight-bottom'
        )
        if (e.clientY < midY) {
            clone.parentNode.insertBefore(draggingElement, clone)
        } else {
            clone.parentNode.insertBefore(draggingElement, clone.nextSibling)
        }
    })

    // Thêm click event listener
    clone.addEventListener('click', (e) => {
        e.stopPropagation()
        handleElementClick(clone)
    })

    // Chèn element mới vào sau element gốc
    element.parentNode.insertBefore(clone, element.nextSibling)

    // Chọn element mới
    handleElementClick(clone)
}

// Khởi tạo nút duplicate
function initDuplicateButton() {
    const duplicateButton = document.getElementById('duplicate-element')
    if (!duplicateButton) return

    duplicateButton.addEventListener('click', () => {
        if (currentEl) {
            duplicateElement(currentEl)
        } else {
            showNotification('Please select an element to duplicate', 'error')
        }
    })
}

// Hàm xóa element
function deleteElement(element) {
    if (
        !element ||
        element.attr('id') === 'content' ||
        element.attr('id') === 'editor'
    ) {
        showNotification('Cannot delete root elements', 'error')
        return
    }

    if (confirm('Are you sure you want to delete this element?')) {
        element.remove()
        currentEl = null
        initMainPane()
    }
}

// Hàm tạo bảng mới
function createTable(rows = 3, cols = 3) {
    const table = document.createElement('table');
    table.className = 'editor-table';
    table.style.width = '100%';
    table.style.borderCollapse = 'collapse';

    // Tạo tiêu đề bảng
    const thead = document.createElement('thead');
    const headerRow = document.createElement('tr');

    // Thêm ô trống đầu tiên cho giao diện đẹp hơn
    headerRow.innerHTML = '<th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;"></th>';

    // Thêm các cột tiêu đề
    for (let i = 0; i < cols; i++) {
        headerRow.innerHTML += `<th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2; text-align: center;">Tiêu đề ${i + 1}</th>`;
    }
    thead.appendChild(headerRow);

    // Tạo nội dung bảng
    const tbody = document.createElement('tbody');
    for (let i = 0; i < rows; i++) {
        const row = document.createElement('tr');
        row.innerHTML = `<td style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2; text-align: center;">Hàng ${i + 1}</td>`;

        for (let j = 0; j < cols; j++) {
            row.innerHTML += '<td style="border: 1px solid #ddd; padding: 8px;">Ô ' + (i + 1) + '-' + (j + 1) + '</td>';
        }
        tbody.appendChild(row);
    }

    table.appendChild(thead);
    table.appendChild(tbody);

    // Thêm style cho bảng
    const style = document.createElement('style');
    style.textContent = `

    `;
    document.head.appendChild(style);

    return table;
}

// Tạo grid layout dùng Bootstrap
function createBootstrapGrid(rows = 2, cols = 2) {
    const container = document.createElement('div')
    container.className = 'bootstrap-grid-wrapper'
    container.style.margin = '15px 0'

    for (let r = 0; r < rows; r++) {
        const row = document.createElement('div')
        row.className = 'row g-2 mb-2' // Bootstrap row + gap + spacing

        for (let c = 0; c < cols; c++) {
            const col = document.createElement('div')
            const colSize = Math.floor(12 / cols)
            col.className = `col-${colSize}`
            col.style.border = '1px solid #ddd'
            col.style.minHeight = '50px'
            col.style.padding = '10px'
            col.style.backgroundColor = '#f9f9f9'
            col.style.display = 'flex'
            col.style.alignItems = 'center'
            col.style.justifyContent = 'center'
            col.textContent = `Cell ${r * cols + c + 1}`
            row.appendChild(col)
        }

        container.appendChild(row)
    }

    return container
}

// Hiển thị hộp thoại tạo grid
function showGridDialog() {
    const rows = prompt('Nhập số hàng (tối đa 6):', '2')
    const cols = prompt('Nhập số cột (tối đa 6):', '2')
    const confirmCreate = confirm(`Bạn có chắc chắn muốn tạo grid ${rows}x${cols}?`)

    if (!confirmCreate) return

    const numRows = Math.min(parseInt(rows) || 2, 6)
    const numCols = Math.min(parseInt(cols) || 2, 6)

    if (numRows > 0 && numCols > 0) {
        const grid = createBootstrapGrid(numRows, numCols)
        const content = document.getElementById('content')

        if (currentEl) {
            currentEl.after(grid)
        } else {
            content.appendChild(grid)
        }

        handleElementClick(grid)
        saveCurrentState()
    } else {
        showNotification('Vui lòng nhập số hàng và số cột hợp lệ', 'error')
    }
}


function createElement(tag, classList = []) {
    const el = document.createElement(tag)
    el.classList.add(...classList)
    return el
}

// Hàm khởi tạo chức năng tải ảnh lên
function initImageUpload() {
    const uploadBtn = document.getElementById('upload-image')
    const fileInput = document.getElementById('image-upload')
    const content = document.getElementById('content')

    if (!uploadBtn || !fileInput || !content) return

    // Nhấn nút => mở chọn file
    uploadBtn.addEventListener('click', () => fileInput.click())

    fileInput.addEventListener('change', (e) => {
        const file = e.target.files?.[0]
        if (!file) return

        // Kiểm tra định dạng và dung lượng
        if (!file.type.startsWith('image/')) {
            showNotification('Vui lòng chọn file ảnh hợp lệ (JPG, PNG, GIF, WEBP)', 'error')
            return
        }
        if (file.size > 5 * 1024 * 1024) {
            showNotification('Kích thước ảnh tối đa là 5MB', 'error')
            return
        }

        const reader = new FileReader()
        reader.onload = (event) => {
            const imgUrl = event.target.result
            const selected = document.querySelector('.selected-element')

            const img = document.createElement('img')
            img.src = imgUrl
            img.draggable = true

            saveCurrentState()

            if (selected) {
                selected.appendChild(img)
            } else {
                const newElement = document.createElement('div')
                newElement.classList.add('element', 'image-element')
                newElement.appendChild(img)
                content.appendChild(newElement)
                handleElementClick(newElement)
            }

            saveCurrentState()
            initDraggable()
        }

        reader.readAsDataURL(file)
        fileInput.value = ''
    })
}


// Khởi tạo nút thêm grid
function initGridButton() {
    const gridButton = document.getElementById('add-grid');
    if (gridButton) {
        gridButton.addEventListener('click', showGridDialog);
    }
}

// Hiển thị hộp thoại tạo bảng
function showTableDialog() {
    const rows = prompt('Nhập số hàng (tối đa 10):', '3');
    const cols = prompt('Nhập số cột (tối đa 10):', '3');
    const confirm = prompt('Bạn có chắc chắn muốn tạo bảng không? (Yes/No)', 'Yes');

    if (confirm !== 'Yes') return;

    const numRows = Math.min(parseInt(rows) || 3, 10);
    const numCols = Math.min(parseInt(cols) || 3, 10);

    if (numRows > 0 && numCols > 0) {
        const table = createTable(numRows, numCols);
        const content = document.getElementById('content');

        if (currentEl) {
            // Chèn sau element hiện tại nếu có element được chọn
            currentEl.after(table);
        } else {
            // Nếu không có element nào được chọn, thêm vào cuối
            content.appendChild(table);
        }

        // Chọn bảng vừa tạo
        handleElementClick(table);



        // Khởi tạo lại các sự kiện
        initDraggable();

        // Lưu trạng thái
        saveCurrentState();
    } else {
        showNotification('Vui lòng nhập số hàng và số cột hợp lệ', 'error');
    }
}

// Khởi tạo nút thêm bảng
function initTableButton() {
    const tableButton = document.getElementById('add-table');
    if (tableButton) {
        tableButton.addEventListener('click', showTableDialog);
    }
}

// Khởi tạo nút delete
function initDeleteButton() {
    const $deleteButton = $('#delete-element')
    if ($deleteButton.length === 0) return

    $deleteButton.on('click', function () {
        if (currentEl) {
            deleteElement($(currentEl))
        } else {
            showNotification('Please select an element to delete', 'error')
        }
    })
}

const elementTemplates = {
    grid: `
        <div class="row">
            <div class="col-md-6">
                <div class="p-3 border">Column 1</div>
            </div>
            <div class="col-md-6">
                <div class="p-3 border">Column 2</div>
            </div>
        </div>
    `,
    container: `
        <div class="container">
            <div class="p-3">Container Content</div>
        </div>
    `,
    card: `
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Card Title</h5>
                <p class="card-text">Card content goes here.</p>
                <button class="btn btn-primary">Button</button>
            </div>
        </div>
    `,
    button: `
        <button class="btn btn-primary">Button</button>
    `,
    text: `
        <p>Text content goes here.</p>
    `,
}

// Khởi tạo drag and drop cho elements
function initElementsDragAndDrop() {
    const $elementItems = $('.element-item')
    const $contentArea = $('#content')

    $elementItems.on('dragstart', function (e) {
        e.originalEvent.dataTransfer.setData('text/plain', $(this).data('type'))
        $(this).addClass('dragging')
    })

    $elementItems.on('dragend', function () {
        $(this).removeClass('dragging')
    })

    function createNewElement(elementType) {
        const $wrapper = $('<div></div>').html(elementTemplates[elementType])
        const $newElement = $wrapper.children().first()

        if ($newElement.length) {
            $newElement.attr('draggable', 'true')
            makeElementEditable($newElement[0])

            $newElement.on('click', function (e) {
                e.stopPropagation()
                handleElementClick(this)
            })

            $newElement.on('dragstart', function (e) {
                e.stopPropagation()
                e.originalEvent.dataTransfer.effectAllowed = 'move'
                e.originalEvent.dataTransfer.setData('text/plain', '')
                $(this).addClass('dragging')
                setTimeout(() => {
                    $(this).css('pointer-events', 'none')
                }, 0)
            })

            $newElement.on('dragend', function (e) {
                e.stopPropagation()
                $(this).removeClass('dragging')
                $(this).css('pointer-events', '')
            })

            $newElement.on('dragover', function (e) {
                e.preventDefault()
                e.stopPropagation()
                const $dragging = $('.dragging').first()
                if (
                    !$dragging.length ||
                    $dragging[0] === this ||
                    $.contains(this, $dragging[0])
                )
                    return

                const rect = this.getBoundingClientRect()
                const midY = rect.top + rect.height / 2

                $(this).removeClass(
                    'drag-over-highlight-top drag-over-highlight-bottom'
                )
                if (e.originalEvent.clientY < midY) {
                    $(this).addClass('drag-over-highlight-top')
                } else {
                    $(this).addClass('drag-over-highlight-bottom')
                }
            })

            $newElement.on('drop', function (e) {
                e.preventDefault()
                e.stopPropagation()
                const $dragging = $('.dragging').first()
                if (
                    !$dragging.length ||
                    $dragging[0] === this ||
                    $.contains(this, $dragging[0])
                )
                    return

                const rect = this.getBoundingClientRect()
                const midY = rect.top + rect.height / 2

                if (e.originalEvent.clientY < midY) {
                    $(this).before($dragging)
                } else {
                    $(this).after($dragging)
                }
            })
        }

        return $newElement
    }

    $contentArea.on('drop', function (e) {
        e.preventDefault()
        e.stopPropagation()
        $contentArea.removeClass('drag-over')

        const elementType = e.originalEvent.dataTransfer.getData('text/plain')
        if (!elementType) return

        const $newElement = createNewElement(elementType)
        if (!$newElement) return

        const $dropTarget = $(e.target).closest('#content *')
        const $target = $dropTarget.length ? $dropTarget : $contentArea

        const rect = $target[0].getBoundingClientRect()
        const y = e.originalEvent.clientY - rect.top

        if (y < rect.height / 2) {
            $target.prepend($newElement)
        } else {
            $target.append($newElement)
        }

        handleElementClick($newElement[0])
        showNotification(`Added new ${elementType} element`, 'success')
    })

    $contentArea.on('dragover', function (e) {
        e.preventDefault()
        e.stopPropagation()

        const $dropTarget = $(e.target).closest('#content *')
        const $target = $dropTarget.length ? $dropTarget : $contentArea

        const rect = $target[0].getBoundingClientRect()
        const y = e.originalEvent.clientY - rect.top

        $('.drag-over-highlight-top, .drag-over-highlight-bottom').removeClass(
            'drag-over-highlight-top drag-over-highlight-bottom'
        )

        if (y < rect.height / 2) {
            $target.addClass('drag-over-highlight-top')
        } else {
            $target.addClass('drag-over-highlight-bottom')
        }
    })

    $contentArea.on('dragleave', function (e) {
        if (!$.contains($contentArea[0], e.relatedTarget)) {
            $contentArea.removeClass('drag-over')
            $('.drag-over-highlight-top, .drag-over-highlight-bottom').removeClass(
                'drag-over-highlight-top drag-over-highlight-bottom'
            )
        }
    })
}

// Hàm thêm/xóa link cho element
function toggleLink(element) {
    // Nếu element đã có link cha là thẻ a
    const parentLink = element.closest('a[href]');

    if (parentLink) {
        // Nếu đã có link, xóa link
        const parent = parentLink.parentNode;
        while (parentLink.firstChild) {
            parent.insertBefore(parentLink.firstChild, parentLink);
        }
        parent.removeChild(parentLink);
        return { action: 'removed' };
    } else {
        // Nếu chưa có link, thêm link mới
        return { action: 'add' };
    }
}

// Hàm hiển thị dialog nhập link
function showLinkDialog(currentHref, callback) {
    const link = prompt('Nhập đường dẫn URL:', currentHref || 'https://');
    if (link !== null) { // Nếu người dùng không bấm Cancel
        callback(link);
    }
}

// Khởi tạo nút link
function initLinkButton() {
    $('#link-element').on('click', function () {
        if (!currentEl) return;

        const parentLink = currentEl.closest('a[href]');
        const hasLink = parentLink !== null;

        if (hasLink) {
            // Xóa link
            const result = toggleLink(currentEl);
            if (result.action === 'removed') {
                $(this).html('<i class="fas fa-link"></i> Add Link');
                $(this).removeClass('btn-danger').addClass('btn-info');
            }
        } else {
            // Thêm link mới
            showLinkDialog('', (linkUrl) => {
                if (linkUrl) {
                    const a = document.createElement('a');
                    a.href = linkUrl;
                    a.target = '_blank';

                    // Bọc element bằng thẻ a
                    currentEl.parentNode.insertBefore(a, currentEl);
                    a.appendChild(currentEl);

                    // Cập nhật giao diện
                    $('#link-element').html('<i class="fas fa-unlink"></i> Remove Link');
                    $('#link-element').removeClass('btn-info').addClass('btn-danger');
                }
            });
        }
    });
}

// Cập nhật trạng thái nút link khi chọn element
function updateLinkButtonState() {
    if (!currentEl) return;

    const parentLink = currentEl.closest('a[href]');
    const hasLink = parentLink !== null;

    const linkButton = $('#link-element');
    if (hasLink) {
        linkButton.html('<i class="fas fa-unlink"></i> Remove Link');
        linkButton.removeClass('btn-info').addClass('btn-danger');
    } else {
        linkButton.html('<i class="fas fa-link"></i> Add Link');
        linkButton.removeClass('btn-danger').addClass('btn-info');
    }
}


// Khởi tạo
document.addEventListener('DOMContentLoaded', function () {
    initMainPane()
    initDraggable()
    initUndoButton()

    // Lưu trạng thái ban đầu
    saveCurrentState()
    initSaveContent()
    initDuplicateButton()
    initDeleteButton()
    initElementsDragAndDrop()
    initLinkButton()
    initTableButton()
    initGridButton()
    initImageUpload()

    // Cập nhật trạng thái nút link khi chọn element mới
    $(document).on('click', function (e) {
        if (e.target === document.querySelector('#content') || e.target.closest('#content')) {
            setTimeout(updateLinkButtonState, 50); // Đợi một chút để currentEl được cập nhật
        }
    });

    // Click handler cho các element
    $(document).on('click', '#content *', function (e) {
        e.preventDefault()
        e.stopPropagation()
        handleElementClick(this)
    })

    $(document).on('keydown', function (e) {
        if (!currentEl || !currentEl.contentEditable) return

        const isCtrl = e.ctrlKey || e.metaKey
        const isShift = e.shiftKey

        if (e.key === 'Delete') {
            deleteElement($(currentEl))
        }

        if (isCtrl) {
            switch (e.key.toLowerCase()) {
                case 'b':
                    e.preventDefault()
                    toggleTextFormat('bold')
                    break
                case 'i':
                    e.preventDefault()
                    toggleTextFormat('italic')
                    break
                case 'u':
                    e.preventDefault()
                    toggleTextFormat('underline')
                    break
                case 's':
                    e.preventDefault()
                    toggleTextFormat('strikeThrough')
                    break
                case 'z':
                    e.preventDefault()
                    document.execCommand('undo')
                    break
                case 'y':
                    e.preventDefault()
                    document.execCommand('redo')
                    break
                case 'k':
                    e.preventDefault()
                    if (!isShift) {
                        const url = prompt('Nhập URL liên kết:')
                        if (url) document.execCommand('createLink', false, url)
                    } else {
                        document.execCommand('unlink')
                    }
                    break
            }
        }
    })

    // Click bên ngoài để bỏ chọn
    $('#editor').on('click', function (e) {
        if (e.target === this && currentEl) {
            currentEl.classList.remove('selected-element')
            currentEl = null
            initMainPane() // Reset về pane mặc định
        }
    })
})
