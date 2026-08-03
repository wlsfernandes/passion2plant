document.addEventListener("DOMContentLoaded", function () {
    if (typeof CKEDITOR === "undefined") {
        console.warn("CKEditor not loaded.");
        return;
    }

    document.querySelectorAll(".ckeditor").forEach((element) => {
        CKEDITOR.ClassicEditor.create(element, {
            toolbar: {
                items: [
                    "heading",
                    "|",
                    "fontFamily",
                    "fontSize",
                    "fontColor",
                    "|",
                    "bold",
                    "italic",
                    "underline",
                    "|",
                    "bulletedList",
                    "numberedList",
                    "|",
                    "alignment",
                    "|",
                    "link",
                    "blockQuote",
                    "insertTable",
                    "|",
                    "undo",
                    "redo",
                ],
            },
            fontColor: {
                colors: [
                    // Neutral colors
                    { color: "#000000", label: "Black" },
                    { color: "#FFFFFF", label: "White" },
            
                    // Passion2Plant brand colors
                    { color: "#E05E4E", label: "Passion Coral" },
                    { color: "#EEA53F", label: "Plant Gold" },
                    { color: "#938A42", label: "Rooted Olive" },
                    { color: "#6A3C2D", label: "Soil Brown" },
                    { color: "#0E1911", label: "Canopy Black" },
                    { color: "#FFF8EE", label: "Sprout Cream" },
            
                    // Existing website and utility colors
                    { color: "#4B8941", label: "Original Green" },
                    { color: "#198754", label: "Success Green" },
                    { color: "#B04F4F", label: "Primary Red" },
                    { color: "#DC3545", label: "Danger Red" },
                    { color: "#FFC46B", label: "Warning Yellow" },
                    { color: "#0D6EFD", label: "Primary Blue" },
                    { color: "#6C757D", label: "Gray" },
            
                    // Optional accent colors
                    { color: "#F59E0B", label: "Accent Orange" },
                    { color: "#9333EA", label: "Purple" },
                ],
                columns: 5,
            },
            
            fontFamily: {
                options: [
                    "default",
            
                    // Passion2Plant brand fonts
                    "Montserrat, Arial, Helvetica, sans-serif",
                    "DM Serif Display, Georgia, serif",
                    "Source Sans 3, Arial, Helvetica, sans-serif",
            
                    // Standard fallback fonts
                    "Arial, Helvetica, sans-serif",
                    "Georgia, serif",
                    "Times New Roman, Times, serif",
                    "Poppins, Arial, sans-serif",
                    "Roboto, Arial, sans-serif",
                ],
                supportAllValues: false,
            },
            fontSize: {
                options: [
                    10,
                    12,
                    14,
                    "default",
                    18,
                    20,
                    24,
                    28,
                    32,
                    36,
                    48,
                    72,
                ],
            },

            removePlugins: [
                "CKBox",
                "CKFinder",
                "EasyImage",
                "RealTimeCollaborativeComments",
                "RealTimeCollaborativeTrackChanges",
                "RealTimeCollaborativeRevisionHistory",
                "PresenceList",
                "Comments",
                "TrackChanges",
                "TrackChangesData",
                "RevisionHistory",
                "Pagination",
                "WProofreader",
                "DocumentOutline",
                "TableOfContents",
                "FormatPainter",
                "SlashCommand",
                "PasteFromOfficeEnhanced",
                "Template",
            ],
        }).catch((error) => {
            console.error("CKEditor error:", error);
        });
    });

    document.querySelectorAll(".ckeditor-title").forEach((element) => {
        CKEDITOR.ClassicEditor.create(element, {
            toolbar: {
                items: [
                    "fontFamily",
                    "fontSize",
                    "fontColor",
                    "|",
                    "bold",
                    "italic",
                    "underline",
                    "|",
                    "alignment",
                    "|",
                    "undo",
                    "redo",
                ],
            },
            fontColor: {
                colors: [
                    // Neutral colors
                    { color: "#000000", label: "Black" },
                    { color: "#FFFFFF", label: "White" },
            
                    // Passion2Plant brand colors
                    { color: "#E05E4E", label: "Passion Coral" },
                    { color: "#EEA53F", label: "Plant Gold" },
                    { color: "#938A42", label: "Rooted Olive" },
                    { color: "#6A3C2D", label: "Soil Brown" },
                    { color: "#0E1911", label: "Canopy Black" },
                    { color: "#FFF8EE", label: "Sprout Cream" },
            
                    // Existing website and utility colors
                    { color: "#4B8941", label: "Original Green" },
                    { color: "#198754", label: "Success Green" },
                    { color: "#B04F4F", label: "Primary Red" },
                    { color: "#DC3545", label: "Danger Red" },
                    { color: "#FFC46B", label: "Warning Yellow" },
                    { color: "#0D6EFD", label: "Primary Blue" },
                    { color: "#6C757D", label: "Gray" },
            
                    // Optional accent colors
                    { color: "#F59E0B", label: "Accent Orange" },
                    { color: "#9333EA", label: "Purple" },
                ],
                columns: 5,
            },
            
            fontFamily: {
                options: [
                    "default",
            
                    // Passion2Plant brand fonts
                    "Montserrat, Arial, Helvetica, sans-serif",
                    "DM Serif Display, Georgia, serif",
                    "Source Sans 3, Arial, Helvetica, sans-serif",
            
                    // Standard fallback fonts
                    "Arial, Helvetica, sans-serif",
                    "Georgia, serif",
                    "Times New Roman, Times, serif",
                    "Poppins, Arial, sans-serif",
                    "Roboto, Arial, sans-serif",
                ],
                supportAllValues: false,
            },

            fontSize: {
                options: [
                    10,
                    12,
                    14,
                    "default",
                    18,
                    20,
                    24,
                    28,
                    32,
                    36,
                    48,
                    72,
                ],
            },

            removePlugins: [
                "CKBox",
                "CKFinder",
                "EasyImage",
                "RealTimeCollaborativeComments",
                "RealTimeCollaborativeTrackChanges",
                "RealTimeCollaborativeRevisionHistory",
                "PresenceList",
                "Comments",
                "TrackChanges",
                "TrackChangesData",
                "RevisionHistory",
                "Pagination",
                "WProofreader",
                "DocumentOutline",
                "TableOfContents",
                "FormatPainter",
                "SlashCommand",
                "PasteFromOfficeEnhanced",
                "Template",
            ],
        });
    });
});
