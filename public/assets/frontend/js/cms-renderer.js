document.addEventListener("DOMContentLoaded", function () {
    const containers = document.querySelectorAll(".cms-content");

    containers.forEach((container) => {
        const styledNodes = container.querySelectorAll("[style]");

        styledNodes.forEach((node) => {
            const style = node.getAttribute("style");

            if (!style) return;

            const colorMatch = style.match(/color\s*:\s*([^;]+)/i);
            const sizeMatch = style.match(/font-size\s*:\s*([^;]+)/i);
            const fontMatch = style.match(/font-family\s*:\s*([^;]+)/i);

            const color = colorMatch ? colorMatch[1].trim() : null;
            const size = sizeMatch ? sizeMatch[1].trim() : null;
            const font = fontMatch ? fontMatch[1].trim() : null;

            const applyStyles = (el) => {
                if (color) {
                    el.style.setProperty("color", color, "important");
                    el.style.setProperty(
                        "-webkit-text-fill-color",
                        color,
                        "important",
                    );
                }

                if (size) {
                    el.style.setProperty("font-size", size, "important");
                }

                if (font) {
                    el.style.setProperty("font-family", font, "important");
                }
            };

            applyStyles(node);

            node.querySelectorAll("*").forEach((child) => {
                applyStyles(child);
            });
        });
    });
});
