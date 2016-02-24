export class Error {

    public static show(errorXHR: JQueryXHR) {
        this.clear();
        let error = errorXHR.responseJSON;
        if (error.message === "error") {
            $("#error_container").removeClass("hidden").fadeIn("fast");
            $.each(error.errors, (key, value) => {
                $("#errors").append("<li>" + value + "</li>");
            });

        }
    }

    public static hide() {
        $("#error_container").addClass("hidden");
        this.clear();
    }

    public static showErrorPage() {
        $("#content").load("templates/404.html");
    }

    private static clear() {
        $("#errors").empty();
    }
}